<?php
namespace Home\Controller;

use Think\Controller;

class RoleManagerController extends Controller{

	public function update(){
		$all = M('privilege')->where(array('class' => 1))->select(); //查询全部
		foreach ($all as $key => $value) {

			$all[$key] = $this->stack($value['id'],$all[$key]);
		}
		//所有资源
		$this->assign('all',$all);

		if(!empty(I("id"))){
			$privilege = M('role_privilege')->field("privilege_id")->where('role_id ='.I('id'))->select();
		}
		if(isset($privilege)){
			$string = "|";
			foreach ($privilege as $key => $value) {
				$string .= $value['privilege_id'].'|';
			}
			//该角色所有的权限凭借的字符串
			$this->assign("string",$string);
		}

		$info = M('role')->where('id = '.I("id"))->find();
		$this->assign("info",$info);

		$this->display();
	}
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
		// dump($all);
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


	public function updateAction(){
		$data = I('post.');
		$data['status'] = empty($data['status']) ? 1 :0;
		$data['rolename'] = $data['rolename'];
		$data['description'] = $data['description'];

		M('role')->where('id = '.$data['id'])->save($data);

		M("role_privilege")->where('role_id = '.$data['id'])->delete();

		$save['role_id'] = $data['id'];

		for ($i = 0; $i < count($data['privilege_id']);$i ++){
			$save['privilege_id'] = $data['privilege_id'][$i];
			M('role_privilege')->add($save);
		}

		$this->redirect("RoleManager/index");
	}
}