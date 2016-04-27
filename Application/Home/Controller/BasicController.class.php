<?php
namespace Home\Controller;
use Think\Controller;


class BasicController extends Controller{

	public function __construct(){
		parent::__construct();
		if(!session("?userid")){
			$this->redirect('Login/login');
		}
	}

}