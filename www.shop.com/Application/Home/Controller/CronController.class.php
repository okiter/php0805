<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/21
 * Time: 16:45
 */

namespace Home\Controller;


use Think\Controller;


class CronController extends Controller
{

    public function clicktimes2Mysql(){
        //>>1.链接到redis中
            $redis = getRedis();
        //>>2.从redis中取出浏览次数
             $keys = $redis->keys('goods_click_times:*');
             $values = $redis->mget($keys);
        //>>3.将redis中的浏览次数更新到数据库中
             foreach($keys as $i=>$key){
//                $goods_id = ltrim($key,"goods_click_times:");
                  $goods_id =  str2arr($key,':')[1];  //从redis的键中取出商品的id
                  $goods_times=  $values[$i];  //对应取出浏览次数

                 $goodsTimesModel = M("GoodsTimes");
                 $row = $goodsTimesModel->where(array('goods_id'=>$goods_id))->find();
                 if($row){
                     //>>3.如果有, 就更新 +1
                     $goodsTimesModel->where(array('goods_id'=>$goods_id))->setInc('times',$goods_times);
                 }else{
                     //>>2.如果没有就在当前上面添加进去
                     $goodsTimesModel->add(array('goods_id'=>$goods_id,'times'=>$goods_times));
                 }
             }
        //>>4.删除redis中的浏览次数
              $redis->del($keys);
    }
}