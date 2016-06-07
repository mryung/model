<?php
namespace Home\Controller;

use \Home\Controller\BasicController;

class IndexController extends BasicController {

    public function index(){
    	
    	//查询出用用所有的权限
    	$array = M("privilege")->order("class")->select();
    
    	$tree = array();
    	$tree = $this->stackTree($tree, 0, $array);
    	showTree($tree, $content, 0);
//     	dump($tree);
    	
    	$this->assign("tree",$content);
    	$this->display();
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