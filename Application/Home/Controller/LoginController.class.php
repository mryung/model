<?php
namespace Home\Controller;
use Think\Controller;

class  LoginController extends Controller{
	public function login(){
		session_destroy();
		$this->display();
	}
	public function vertifyUser(){
		$data = I('post.');

		$userInfo = M('user')->where($data)->find();
		if($userInfo){
			session("userid",$userInfo['id']);
			session("userName",$userInfo['username']);
			$this->redirect('Index/index');
		}else{
			$this->display('login');
			// $this->error("用户错误",'',1);
		}

	}
	public function loginOut(){
		session_destroy();
		$this->redirect("Login/login");
	}
}

