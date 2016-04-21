<?php
namespace Home\Controller;

use Think\Controller;

//用户管理列表
class UserManagerController extends Controller{

	public function add(){
		//查询开启的用户
		$info = M('role')->where(array('status' => 0))->select();
		$this->assign("info",$info);
		$this->display();
	}
	public function addAction(){

		$userInfo['username'] = I('post.username');
		$data["user_id"] = M('user')->add($userInfo);

		$permision = I('post.permission');
		$count = count($permision);

		for ($i = 0 ;$i < $count; $i ++){
			$data['role_id'] = $permision[$i];
			M('user_role')->add($data);
		}
		$this->redirect('add');
	}

	public function index(){
		$info = M('user')->select();

		foreach ($info as $key => $value) {
			$data = M('role')
				->join('user_role on user_role.role_id = role.id')
				->join('user on user_role.user_id = user.id')
				->where('user.id = '.$value['id'])
				->field('role.rolename')
				->select();
			$info[$key]['role'] = $data;
		}

		$this->assign("info",$info);
		$this->display();
	}
}