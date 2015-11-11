<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/11
 * Time: 15:14
 */

namespace Admin\Service;


class LoginService
{

    /**
     * 根据用户名和密码进行登陆
     * @param $username
     * @param $password
     */
    public function login($username,$password){
        //>>1.先判断用户名
          $adminModel = D('Admin');
          $row = $adminModel->getByUsername($username);
          if($row){
              //>>2.再判断密码(将当前登陆用户名的密码进行加密之后再和数据库中的密码进行对比)
                $password = md5($password.$row['salt']);
                if($row['password']==$password){
                    return $row;
                }else{
                    return '密码错误!';
                }
          }else{
              return '用户名错误或者不存在';
          }
    }

    /**
     * 根据用户的id找到用户能够访问的url地址
     * @param $admin_id
     */
    public function getPermissionURL($admin_id){
                $sql = "select  distinct  url from permission  where id in
        (select  distinct rp.permission_id from  admin_role as ar  join role_permission as rp on ar.role_id = rp.role_id  where ar.admin_id = 3)
        or id in(select  ap.permission_id from admin_permission as ap where ap.admin_id = $admin_id);";

              $rows =   M()->query($sql);
        return array_column($rows,'url');
    }
}