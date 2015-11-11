<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 14:47
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class VerifyController extends Controller
{

    public function index(){
        $verify = new Verify();
        $verify->entry();
    }
}