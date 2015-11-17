<?php


$mailThread = new MailThread();
$mailThread->start();


class  MailThread extends Thread{

    public function run(){
        require './PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // 开启调试模式
        $mail->isSMTP();                                      // 设置发送邮件协议: SMTP
        $mail->Host = 'smtp.126.com';                         // 设置邮件的服务器
        $mail->SMTPAuth = true;                               // 开启授权
        $mail->Username = 'itsource520@126.com';              // 登陆用户的用户名
        $mail->Password = 'qqitsource520';                    // 登陆用户的密码
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//$mail->Port = 587;                                    // TCP port to connect to


/////////////////////准备邮件内容///////////////////////////////////////
        $mail->setFrom('itsource520@126.com', 'Mailer');          //发件人
        $mail->addAddress('itsource520@126.com', 'Joe User');     // 收件人
//$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('itsource520@126.com', 'Information');
//$mail->addCC('cc@example.com');  //抄送
//$mail->addBCC('bcc@example.com');  //密送


        //添加附件
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // 设置邮件为Html的邮件
        $mail->CharSet = 'utf-8';                              //设置编码
        $mail->Subject = '这是一份邮件';   //邮件的标题
        $mail->Body    = '这是一份邮件<b>in bold!</b>';   //邮件的内容
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';  //没有html的邮件内容


////////////////////发送邮件//////////////////////////////
        $mail->send();
    }
}