<?php
namespace Home\Controller;

use Think\Controller;

class  TestController extends Controller{
	
	
	//这个函数是成功生成 数
	public function index(){
		
		$array = M("privilege")->order("class")->select();
		
		$tree = array();
		$tree = $this->stackTree($tree, 0, $array);
		dump($tree);
		$content = "";
		showTree($tree, $content, 0);
		
		dump($content);
		
		$this->assign("tree",$content);
		$this->display();
	}
	
	public function  makeTree($tree){
		
	}
	
	public function stackTree(&$tree,$parentid,$info){
		
		foreach ($info as $var){
			
			if($var["parent_id"] == $parentid){
				if(!is_array($tree["child"])){
					$tree["child"] = array();
				}
				$temp = array_push($tree["child"], $var);
				
				$this->stackTree($tree["child"][$temp - 1],$tree["child"][$temp - 1]['id'],$info);
			}
			
		}
		return $tree;
	}
	
}