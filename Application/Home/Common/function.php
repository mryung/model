<?php

function hasPrivilege($string,$privilegeId){

	if(strstr($string, "|".$privilegeId."|")){
		return "checked='checked'";
	}
}