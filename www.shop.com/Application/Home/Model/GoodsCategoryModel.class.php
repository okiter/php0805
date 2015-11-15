<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/14
 * Time: 10:40
 */

namespace Home\Model;


use Think\Model;

class GoodsCategoryModel extends Model
{

    /**
     * 用来获取所有需要在前台显示的分类数据
     */
    public function getList(){
        //>>1.先从缓存中查找
        $goodsCategorys = S('GoodsCategorys');
        if(empty($goodsCategorys)){
            //>>2.没有找到,就从数据库中查找
            $goodsCategorys = $this->field('id,name,parent_id,level')->where(array('status'=>1))->order('lft')->select();
            //>>3.将其存放到缓存中
            S('GoodsCategorys',$goodsCategorys);
        }
        return  $goodsCategorys;
    }
}