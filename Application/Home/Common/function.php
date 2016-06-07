<?php

function hasPrivilege($string,$privilegeId){

	if(strstr($string, "|".$privilegeId."|")){
		return "checked='checked'";
	}
}

function showTree($tree,&$content,$count){

	if(is_array($tree["child"])){
		$content =$content . "<ul style='margin-left: ". 10*$count ."px;list-style:none'>";
		
		foreach ($tree["child"] as $var){
			
			if($var['show_index'] == 1){
				if($var["click"] == 1){
					$content .="<li>".$var["privilege_desc"]."</li>";
				}else{
					$content .="<li><a class='target' data-target='".U($var['privilege_name'])."'>".$var["privilege_desc"]."</a></li>";
				}				
			}
			showTree($var, $content, $count+1);
		}
		$content .= "</ul>";
		
		
	}
	return $content;
}