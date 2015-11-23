<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/15
 * Time: 10:49
 */

namespace Home\Controller;


use Think\Controller;

class MemberController extends Controller
{

    public function regist(){
        if(IS_POST){

            //>>1.注册之前先对短信验证码进行验证.
         /*   $checkCode = I('post.checkcode');  //请求中用户输入的验证码
            $sms_code = session('SMS_CODE');
            if($checkCode!==$sms_code){
                 $this->error('短信验证码错误!');
            }else{
                 session('SMS_CODE',null);  //短信验证成功之后删除保存在session中短信内容
            }*/
            $memberModel = D('Member');
            if($memberModel->create()!==false){
                if($memberModel->add()!==false){
                    $this->success('注册成功',U('login'));
                    return;
                }
            }
            $this->error('注册失败!'.$memberModel->getError());
        }else{
            $this->display('regist');
        }
    }



    public function login(){
        if(IS_POST){
            $memberModel = D('Member');
            if($memberModel->create()!==false){  //收集请求参数
                $result = $memberModel->login();
                if(is_array($result)){
                    login($result);

                    //从cookie中获取到url
                    $login_return_url = cookie('__LOGIN_RETURN_URL__');
                    if(empty($login_return_url)){
                        $login_return_url =  U('Index/index');
                    }else{
                        cookie('__LOGIN_RETURN_URL__',null);
                    }
                    $this->success('登陆成功!',$login_return_url);  //登陆成功之后跳转到首页
                }else{
                    $this->error('登录失败!'.$memberModel->getError());
                }
            }
        }else{
            $this->display();
        }
    }

    public function logout(){
        logout();
        $this->success('注销成功!',U('Index/index'));
    }

    /**
     * 验证数据是否重复
     */
    public function check(){
        //>>1.获取请求参数
        $params = I("get.");
        //>>2.让模型进行验证
        $memberModel=  D('Member');
        /**
         * result的值一定要是true或者false
         */
        $result = $memberModel->checkRepeat($params);
        //>>3.验证的结果
        $this->ajaxReturn($result);
    }


    /**
     * 发送验证码给这个电话号码
     * @param $tel
     */
    public function sendSMS($tel){
        $memberModel = D('Member');
        //发送短信的结果: true或者false
        $result = $memberModel->sendSMS($tel);
        $this->ajaxReturn($result);
    }


    public function fire($id,$key){
        $memberModel = D('Member');
        $result = $memberModel->fire($id,$key);
        if($result===false){
            $this->error('激活失败!,重新激活');
        }else{
            $this->success('激活成功!',U('login'));
        }
    }


    /**
     * 得到登陆的用户信息
     */
    public function getLoginInfo(){
         if(isLogin()){
                $userinfo = login();
                $this->ajaxReturn($userinfo['username']);
         }
    }
}