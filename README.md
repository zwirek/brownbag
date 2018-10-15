# ReactPHP BrownBag.
## How to run examples
1. `php bin/1_timers.php`
2. `php bin/2_interval.php`
3. `php bin/3_limit_interval.php`
4. `php bin/4_blocking.php`
5. `php bin/5_signals.php` after few second type CTRL+C and you will see SIGTERM output
6. `echo "hello world" | php bin/6_streams.php`
7. `echo "hello world" | php bin/7_streams_pause.php`
8. `echo "hello world" | php bin/8_write_stream.php`
9. `echo "hello world" | php bin/9_pipe.php`
10. `echo "hello world" | php bin/10_more_pipes.php`
11. `php bin/11_duplex_stream.php`
12. `php bin/12_promise.php`
13. `php bin/13_execution_order.php`
14. `php bin/14_promise.php`
15. `php bin/15_promise_all.php`
16. `php bin/16_promise_race.php`
17. `php bin/17_socket.php` in next terminal type `nc -U /tmp/reactphp_server.sock`, then enter something and type enter. To exit netcat type CTRL+D. 
18. `php bin/18_bc_socket.php` like in example nr 17
19. To run example number 19 first download http://distribution.bbb3d.renderfarming.net/video/mp4/bbb_sunflower_2160p_60fps_normal.mp4.
Then change name of file to bbb.mp4, and place it one level higher then project root directory. After that in terminal run `php bin/19_streamming.php`.
Then open browser (it seems that this is working only on Firefox) and type http://127.0.0.1:8080 
20. `php bin/20_chat.php` In next terminal (this not working in iTerm) type `nc 127.0.0.1 8080`. You can use your external IP address as socket bind to every interface. To see conversation at least two client should be connected.

To run benchmark you need docker on your machine. If you have docker then type `vendor/bin/robo start:benchmark`. If you want to know whats is going on under the hood then open the file `RoboFile.php`