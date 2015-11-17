<?php
     header('Content-Type: text/html;charset=utf-8');
        $start = microtime(true);

    //>>1.挖地基
        $thread1 = new Thread1();
        $thread1->start();//调用start开启线程执行,并且在单独的线程中执行run方法的代码
    //>>2.拉砖
        $thread2 = new Thread2();
        $thread2->start();
    //>>3.和灰
        $thread3 = new Thread3();
        $thread3->start();
    //>>4.砌转
        $thread4 = new Thread4();
        $thread4->start();


/*        $thread1->join();  //只有子线程执行完毕之后才回归主线程.
        $thread2->join();
        $thread3->join();
        $thread4->join();*/



        $end = microtime(true);
        echo '<hr/>';
        echo '共花费:'.($end-$start);



/**
 * 新建线程的原理:
 *    将一块代码放到Thread的子类中
 * 1. 创建Thread的子类
 * 2. 将需要在线程中执行的代码放到 Thread子类的run方法中
 * 3. 需要开启线程并且让线程中的代码执行
 */
 class Thread1  extends Thread{
     public function run() {
         file_put_contents('./xxx1.txt','挖地基');
         sleep(2);
     }
 }
 class Thread2  extends Thread{
     public function run() {
         file_put_contents('./xxx2.txt','拉砖');
         sleep(2);
     }
 }
 class Thread3  extends Thread{
     public function run() {
         file_put_contents('./xxx3.txt','和灰');
         sleep(2);
     }
 }
 class Thread4  extends Thread{
     public function run() {
         file_put_contents('./xxx4.txt','砌砖');
         sleep(2);
     }
 }