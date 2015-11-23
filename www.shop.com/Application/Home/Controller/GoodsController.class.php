<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/21
 * Time: 15:56
 */

namespace Home\Controller;


use Think\Controller;

class GoodsController extends Controller
{

    /**
     * 根据该商品的id增加该商品的浏览次数
     * @param $goods_id
     */
    public function addClickTimes($goods_id){
        $goodsTimesModel  = D('GoodsTimes');
        $goodsTimesModel->addClickTimes($goods_id);
    }
}