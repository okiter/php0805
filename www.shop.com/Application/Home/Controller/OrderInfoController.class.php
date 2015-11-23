<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/20
 * Time: 10:20
 */

namespace Home\Controller;


use Think\Controller;

class OrderInfoController extends Controller
{
    public function index(){
        if(!isLogin()){
            //>>1.获取当前请求的地址
            $requestURl = $_SERVER['REQUEST_URI'];
            //>>2.将请求的地址保存到cookie
            cookie('__LOGIN_RETURN_URL__',$requestURl);
           $this->error('请登录!',U('Member/login'));
        }
         //>>1.准备所有的收货人信息
        $addressModel = D('Address');
        $addresses = $addressModel->getList();
        $this->assign('addresses',$addresses);
        //>>2.准备送货方式
        $deliveryModel = D('Delivery');
        $deliverys = $deliveryModel->getShowList();
        $this->assign('deliverys',$deliverys);
        //>>3.准备支付方式
        $payTypeModel = D('PayType');
        $payTypes = $payTypeModel->getShowList();
        $this->assign('payTypes',$payTypes);

        //>>4.准备购物车中的数据
        $shoppingCarModel= D('ShoppingCar');
        $shoppingCar = $shoppingCarModel->getList();
        $this->assign('shoppingCar',$shoppingCar);

        $this->display('index');
    }



    public function add(){
        //>>1.接收请求中的所有参数
        $params = I('post.');
        //>>2.让model保存
        $orderInfoModel = D('OrderInfo');
        $result = $orderInfoModel->add($params);
        if($result!==false){
            $this->success('下单成功!请求支付!',U('pay',array('id'=>$result)));
        }else{
            $this->error('添加失败!'.$orderInfoModel->getError());
        }
    }

    /**
     * 根据id查询出订单的编号和价格
     * @param $id
     */
    public function pay($id){
        $orderInfoModel = D('OrderInfo');
        $orderInfo  = $orderInfoModel->get($id);
        $this->assign($orderInfo);
        $this->display('pay');
    }


    /**
     * 根据id进行支付
     * @param $id
     */
    public function doPay($id){
        $orderInfoModel = D('OrderInfo');
        $orderInfoModel->doPay($id);
    }

    public function return_url(){
        echo 'return_url....';
    }



    public function notify_url(){
        //>>1.通过C方法获取支付宝的配置
        $alipay_config = C('ALIPAY_CONFIG');
        //>>2.加载该类
        vendor("Alipay.lib.alipay_notify#class");
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();  //验证该请求是否来源于支付宝

        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货


                //

                //根据订单号$out_trade_no 更改当前网站中的订单状态
                $this->where(array('sn'=>$out_trade_no))->save(array('order_status'=>1,'pay_status'=>2));

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
                //该判断表示卖家已经发了货，但买家还没有做确认收货的操作


                $this->where(array('sn'=>$out_trade_no))->save(array('order_status'=>5,'shipping_status'=>1));
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");


            }
            else if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //该判断表示买家已经确认收货，这笔交易完成
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                echo "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else {
                //其他状态判断
                echo "success";

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }
}