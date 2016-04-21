<?php
namespace Home\Controller;

use Think\Controller;

class RoleManagerController extends Controller{

	//栈
	public function stack($parentid,$array = array()){

		$data = M("privilege") -> where(array('parent_id' => $parentid)) -> select();

		foreach ($data as $key => $value) {
			$array['child'][$key] =  $this->stack($value['id'],$data[$key]);
		}

		return $array;

	}

	public function add(){

		//展示所用权限
		$all = M('privilege')->where(array('class' => 1))->select(); //查询全部
		foreach ($all as $key => $value) {

			$all[$key] = $this->stack($value['id'],$all[$key]);
		}
		//这里显示模块权限
		$info = M("role")->select();
		// $info = \Home\Util\ToolsUtil::permissionTree($info);
		$this->assign("info",$all);
		$this->display();
	}

	public function addAction(){
		$data = I('post.');
		$data['status'] = empty($data['status']) ? 1 :0;
		$data['gen_time'] = date("Y-m-d");
		$save['role_id'] = M('role')->add($data);

		for ($i = 0; $i < count($data['privilege_id']);$i ++){
			$save['privilege_id'] = $data['privilege_id'][$i];
			M('role_privilege')->add($save);
		}
		$this->redirect("add");
	}

	public function index(){
		$info = M('role')->select();
		$this->assign("info",$info);
		$this->display();
	}
}