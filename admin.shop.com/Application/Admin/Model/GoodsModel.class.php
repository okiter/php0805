<?php
namespace Admin\Model;


use Think\Model;

class GoodsModel extends BaseModel
{
    // 自动验证定义
    protected $_validate_1 = array(
        array('name','require','名称不能够为空!'),
        array('sn','require','货号不能够为空!'),
        array('goods_category_id','require','父分类不能够为空!'),
        array('brand_id','require','品牌不能够为空!'),
        array('supplier_id','require','供货商不能够为空!'),
        array('shop_price','require','本店价格不能够为空!'),
        array('market_price','require','市场价格不能够为空!'),
        array('stock','require','库存不能够为空!'),
        array('is_on_sale','require','是否上架不能够为空!'),
        array('goods_status','require','商品状态不能够为空!'),
        array('keyword','require','关键字不能够为空!'),
        array('logo','require','LOGO不能够为空!'),
        array('status','require','状态不能够为空!'),
        array('sort','require','排序不能够为空!'),
    );


    public function add(){
        $this->startTrans();//开启事务
        //>>1.处理请求中的商品状态 转换为 一个整数
         $this->handleGoodsStatus();
        //>>2.将请求中的内容保存到数据库中
        $id = parent::add();  //一定要调用parent上的add,  因为先保存后才有id的值
        if($id===false){
            $this->rollback();
            return false;
        }
        //>>3.准备货号 并且将货号更新到数据库中       日期+八位的id   20151107000000id
        $sn = date('Ymd').str_pad($id, 8, "0", STR_PAD_LEFT);
        $result = parent::save(array('sn'=>$sn,'id'=>$id));
        if($result===false){
            $this->rollback();
            return false;
        }

        $this->commit();
        return $id;  //保存成功之后返回id
    }



    public function save(){
        //>>1.计算商品状态
        $this->handleGoodsStatus();
        //>>2.进行更新
        return parent::save();
    }

    /**
     * 请求请求中的商品状态的值, 计算出一个整数值代表商品状态
     */
    private function handleGoodsStatus()
    {
        //>>1.处理请求中的商品状态 转换为 一个整数
        $goods_status = 0;
        foreach ($this->data['goods_status'] as $v) {
            $goods_status = $goods_status | $v;   //相与之后得到状态
        }
        $this->data['goods_status'] = $goods_status;
    }


}