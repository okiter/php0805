<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsCategoryController extends BaseController
{
    protected $meta_title = '商品分类';


    public function index()
    {
        $rows = $this->model->getList();
        //>>3.需要将查询出来的数据分配到页面 assign
        $this->assign('rows',$rows);

        $this->assign('meta_title',$this->meta_title); //分配到列表页面上显示
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        //>>4.选择页面显示 display
        $this->display('index');
    }



    //在编辑页面展示之前向页面分配说有的 分类数据
    protected function _before_edit_view(){
        //为准备ztree树中需要的数据
        $rows = $this->model->getList();
        $this->assign('nodes',json_encode($rows));  //因为ztree中需要的是json字符串
    }

}