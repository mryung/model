<?php
namespace Home\Controller;

use Think\Controller;

class ModelManagerController extends Controller{

	public function add(){

		if(!empty(I('id'))){
			$data = M('privilege')->where(array('id' => I('id')))->find();
		}

		$parentid = empty($data['id']) ? 0 : $data['id']; //父id
		$privilegeName = empty($data['privilege_name']) ? '' :  $data['privilege_name'].'/'; //父的路径
		$class = empty($data['class']) ? '1' : ((int)$data['class']+1); //应用的等级


		$this->assign('privilegeName',$privilegeName);
		$this->assign("parentid",$parentid);
		$this->assign("class",$class);
		$this->display();
	}
	public function addAction(){
		$data = I('post.');
		$data['privilege_name'] = $data['parentRight'].$data['privilege_name'];
		M('privilege')->add($data);

		$this->redirect('ModelManager/index');
	}
	public function index(){
		$info = M('privilege')->order('class,sort')->select();
		$this->assign("info",$info);
		$this->display();
	}

}