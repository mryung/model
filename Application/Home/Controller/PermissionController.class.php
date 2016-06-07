<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 权限认证控制器
 * @author admin
 *
 */
class PermissionController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function checkPermission(){
		
	
	}
	
}

// select distinct privilege.id,privilege.parent_id,privilege.privilege_name,privilege.privilege_desc,privilege.class,privilege.sort from user,user_role,role,role_privilege,privilege 
//        where user.id = user_role.user_id and role.id = user_role.role_id 
//              and role.status = 0 and role.id = role_privilege.role_id and role_privilege.privilege_id = privilege.id and user.id = 1;
//              
/*
select distinct user.id user_id, privilege.id,privilege.parent_id,privilege.privilege_name,privilege.privilege_desc,privilege.class,privilege.sort from user,user_role,role,role_privilege,privilege 
       where user.id = user_role.user_id and role.id = user_role.role_id 
             and role.status = 0 and role.id = role_privilege.role_id and role_privilege.privilege_id = privilege.id ;

 */