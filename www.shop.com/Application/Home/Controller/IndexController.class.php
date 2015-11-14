<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {

        $this->assign('isHiddenMenu',false);
        $this->assign('meta_title','京西商城首页');
        $this->display('index');
    }

    public function lst()
    {
        $this->assign('isHiddenMenu',true);
        $this->assign('meta_title','商品列表');
        $this->display('lst');
    }

    public function show()
    {

        $this->assign('isHiddenMenu',true);
        $this->assign('meta_title','京西商城---XXXX商品');
        $this->display('show');
    }

}