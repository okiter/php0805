<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/21
 * Time: 16:03
 */

namespace Home\Model;


use Think\Model;

class GoodsTimesModel extends Model
{

    public function addClickTimes($goods_id){
        //>>1.连接上redis
            $redis  = getRedis();
        //>>2.增加goods_click_times:$goods_id浏览次数
            $redis->incr("goods_click_times:$goods_id");
    /*    //>>1.先检查有没有浏览次数
           $row = $this->where(array('goods_id'=>$goods_id))->find();
            if($row){
                //>>3.如果有, 就更新 +1
                 $this->where(array('goods_id'=>$goods_id))->setInc('times');
            }else{
                //>>2.如果没有就在当前上面添加进去
                $this->add(array('goods_id'=>$goods_id,'times'=>1));
            }*/

    }
}