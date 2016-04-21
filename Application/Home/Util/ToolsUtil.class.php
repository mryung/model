<?php
namespace Home\Util;

class ToolsUtil{
	
	public static function permissionTree($array){
		$count = count($array);
		$info = array();
		for ($i = 0; $i < $count ; $i++){
			array_push($info, $array[$i]); //要入栈
			$info[count($info) - 1]['child'] = array();
			$info[count($info) - 1]['child'] = self::stackPermission($array,$array[$i]['right_id'],$info[count($info) - 1]['child']);
		}
		;
		
		return self::cleanArrays($info);
	}
	public static function stackPermission($array,$parentId,$info){
	
		for($i = 0; $i < count($array); $i ++){
			if($parentId == $array[$i]['parent_tr_id']){
				array_push($info, $array[$i]);
				$info[count($info) - 1]['child'] = array();
				self::stackPermission($array, $array[$i]['right_id'], $info[count($info) - 1]['child']);
			}
		}
		return $info;
	}
	
	public static function cleanArrays($array){
		$count = count($array);
		for ($i = 0 ; $i < $count; $i ++){
			if(count($array[$i]["child"]) == 0){
				unset($array[$i]);
			}
		}
		return $array;
	}
}