<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/14
 * Time: 16:51
 */

namespace Home\Model;


use Think\Model;

class GoodsModel extends Model
{

    /**
     * 根据商品的状态和条数查询出数据
     * @param $goods_status
     * @param int $num
     */
    public function getGoodsbyGoodsStatus($goods_status,$num=5){
        //select id,logo,name,shop_price from goods where goods_status&2>0  and status=1 and is_on_sale = 1 order by sort limit 5
        $wheres = array('status'=>1,'is_on_sale'=>1);
        $rows = $this->field('id,logo,name,shop_price')->where($wheres)->where("goods_status&{$goods_status}>0")->limit($num)->order('sort')->select();
        return $rows;
    }

    /**
     * 根据商品的id获取商品展示页面上需要的数据
     * @param $id
     */
    public function get($id){
        //select g.*,b.name from goods as g join brand as b on g.brand_id = b.id  where g.id = 17
       //>>1.从goods表中查询出 商品数据
       $goods =    $this->field('g.*,b.name as brand_name')->alias('g')->join('__BRAND__ as b  on g.brand_id = b.id')->where(array('g.id'=>$id))->find();

       //>>2.不仅仅只是用goods表中的数据,还需要其他的表中的数据
            //>>2.1查询出当前商品的分类以及父及分类的数据
            $sql = "select gc.id,gc.name from goods_category as gc2 ,goods_category as gc where  gc.lft<=gc2.lft and gc.rght >= gc2.rght  and gc2.id ={$goods['goods_category_id']} and gc.status=1  order by gc.lft";
            $goodsCategorys  = $this->query($sql);
            $goods['goodsCategorys'] = $goodsCategorys;


        //>>3.获取当前商品的相册数据
            //>>3.1 查询出path的值
            $gallerys =  M('GoodsGallery')->field('path')->where(array('goods_id'=>$id))->select();
            //>>3.2 单独取出path的值
            $gallerys = array_column($gallerys,'path');
            array_unshift($gallerys,$goods['logo']);
            $goods['gallerys'] = $gallerys;

        return $goods;
    }
}