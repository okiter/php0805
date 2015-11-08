<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends BaseController
{
    protected $meta_title = '商品';


    //页面展示之前被调用,向页面上分配数据
    protected function _before_edit_view(){
        //>>1.准备分类数据,分配到页面
        $goodsModel = D('GoodsCategory');
        $goodsCategoryes = $goodsModel->getList();
        $this->assign('nodes',json_encode($goodsCategoryes));

        //>>2.准备品牌数据, 分配到页面
        $brandModel = D('Brand');
        $brands = $brandModel->getShowList();
        $this->assign('brands',$brands);
        //>>3.准备供货商数据, 分配到页面
        $supplierModel = D('Supplier');
        $suppliers = $supplierModel->getShowList();
        $this->assign('suppliers',$suppliers);
    }
}