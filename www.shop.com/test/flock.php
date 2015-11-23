<?php
header('Content-Type: text/html;charset=utf-8');


  $file =  fopen('./xxxx.lock','r+');
   if(flock($file,LOCK_EX)){
       echo microtime(true).'<br/>';
       //>>1.该代码执行了 2秒钟
        for($i=0;$i<99999;$i++){
            for($i=0;$i<999999;$i++){

            }
        }
       echo microtime(true).'<br/>';
     flock($file,LOCK_UN);  //解锁,释放锁
   }

  fclose($file);

