<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Session;
use Mail;

class CapchaController extends Controller
{
    public function getBuild()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $captcha = $builder->inline();
        Session::put('captchaPhrase', $builder->getPhrase());
        echo $captcha;
    }

    public function captcha_login_backend()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $captcha = $builder->inline();
        Session::put('captcha_login_backend', $builder->getPhrase());
        echo $captcha;
    }

     
    public function danhgia(){
    	//return Session::get('captchaPhrase');
    	$message = [
            "Bạn phải nhập tiêu đề","Bạn phải nhập email", "Bạn phải nhập số điện thoại", "Bạn phải nhập thông tin Nội dung bình luận",
            "Bạn phải nhập thông tin Mã an toàn!", "Mã an toàn không hợp lệ!",
            "Cám ơn quý khách hàng đã gửi bình luận, đánh giá của mình về sản phẩm của chúng tôi !",
            "Email không đúng định dạng","Bạn phải nhập tên"
        ];
        if(empty($_POST['email'])){
        	return $message[1];
        }elseif(empty($_POST['phone'])){
        	return $message[2];
        }elseif(empty($_POST['subject'])){
            return $message[0];
        }elseif(empty($_POST['content'])){
        	return $message[3];
        }elseif(empty($_POST['name'])){
            return $message[9];
        }elseif(empty($_POST['confirm'])){
        	return $message[4];
        }

        $email = $_POST['email'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  return $message[7];
		}

    	$builder = new CaptchaBuilder;
        $builder->setPhrase(Session::get('captchaPhrase3'));
        if(!$builder->testPhrase($_POST['confirm'])) {
            return $message[5];
        }
        
        //Gửi email
        $data = array('name'=>$_POST['name'],'subject'=>$_POST['subject'],'phone'=>$_POST['phone'],'content'=>$_POST['content'],'email'=>$_POST['email']);
        Mail::send('frontend.mail_contact', $data, function($res) use ($data)
        {
        	$res->from($data['email']);
            $res->to('anhtuananh2008@gmail.com')->subject($data['subject']);
        });
        return $message[6].'-success';

    }
}
