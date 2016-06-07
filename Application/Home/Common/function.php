<?php

function hasPrivilege($string,$privilegeId){

	if(strstr($string, "|".$privilegeId."|")){
		return "checked='checked'";
	}
}

function showTree($tree,&$content,$count){

	if(is_array($tree["child"])){
		$content .= "<ul style='list-style:none'>";
		
		foreach ($tree["child"] as $var){
			
			$content .="<li>".$var["privilege_desc"]."</li>";
			showTree($var, $content, $count+1);
		}
		$content .= "</ul>";
		
		
	}
	return $content;
}