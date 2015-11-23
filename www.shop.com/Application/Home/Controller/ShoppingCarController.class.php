<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/17
 * Time: 16:15
 */

namespace Home\Controller;


use Think\Controller;

class ShoppingCarController extends Controller
{
    /**
     * 展示购物车列表
     */
    public function index(){
         //>>1.得到购物车中的数据
        $shoppingCarModel = D('ShoppingCar');
        $shoppingCar = $shoppingCarModel->getList();
          //>>2.将购物车中的数据分配到页面上
        $this->assign('shoppingCar',$shoppingCar);
        $this->display('index');
    }

    /**
     * 添加商品到购物车中
     */
    public function add(){
        //>>1.接收请求参数
        $params = I('post.');
        //>>2.将请求参数中的内容添加到购物车中
        $shoppingCarModel = D('ShoppingCar');
        $result = $shoppingCarModel->add($params);
        if($result!==false){
            $this->success('添加成功!',U('index'));
        }else{
            $this->error('添加失败!');
        }
    }
}