<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function startBenchmark()
    {
        $command = 'ab -dq -n 10000 -c 10 http://127.0.0.1:8081/';

        $this->say('Start docker');

        $mysql = $this->taskDockerRun('mysql:5.7')
            ->env('MYSQL_ROOT_PASSWORD', 'password')
            ->detached()
            ->printMetadata(false)->printOutput(false)
            ->run();

        sleep(15);

        $this->taskDockerExec($mysql['cid'])
            ->exec("mysql -u root -ppassword -e 'Create database test; use test; Create table data ( id int(11) auto_increment primary key, value varchar(255) not null);'")
            ->printMetadata(false)->printOutput(false)
            ->run();


        $php = $this->taskDockerRun('bitnami/php-fpm:7.1')
            ->detached()
            ->volume(__DIR__, '/code')
            ->link($mysql['cid'], 'mysql')
            ->containerWorkdir('/code')
            ->publish(8081, 8081)
            ->exec('vendor/bin/ppm start -c ppm.json ')
            ->printMetadata(false)->printOutput(false)
            ->run();

        sleep(1);

        $this->say('Start benchmark for PHP-PM');
        $ppm = $this->taskExec($command)->printMetadata(false)->printOutput(false)->run();
        $this->taskDockerRemove($php['cid'])->arg('-f')->arg('-v')->printMetadata(false)->printOutput(false)->run();

        $phpfpm = $this->taskDockerRun('bitnami/php-fpm:7.1')
            ->detached()
            ->volume(__DIR__, '/code')
            ->link($mysql['cid'], 'mysql')
            ->printMetadata(false)->printOutput(false)
            ->run();

        $nginx = $this->taskDockerRun('nginx:latest')
            ->detached()
            ->publish(8081, 80)
            ->volume(__DIR__, '/code')
            ->volume(__DIR__ . '/site.conf', '/etc/nginx/conf.d/default.conf')
            ->link($phpfpm['cid'], 'php')
            ->printMetadata(false)->printOutput(false)
            ->run();

        $this->say('Start benchmark for Nginx + PHP-FPM');
        $fpm = $this->taskExec($command)->printMetadata(false)->printOutput(false)->run();



        foreach ([$nginx, $phpfpm, $mysql] as $container) {
            $this->taskDockerRemove($container['cid'])->arg('-f')->arg('-v')->printMetadata(false)->printOutput(false)->run();
        }

        $this->say('<info>PHP-PM</info>');
        echo $ppm->getMessage();
        echo PHP_EOL . PHP_EOL . '###########################################################################' . PHP_EOL . PHP_EOL;
        $this->say('<info>Nginx + php-fpm</info>');
        echo $fpm->getMessage();
        echo PHP_EOL;
    }
}