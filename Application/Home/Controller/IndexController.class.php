<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

        $data = M('view_privilege')->where('user_id=1')->select();
        // dump($data);
        $info = array();
        foreach ($data as $key => $value) {
            if(!is_array($info[$value['parent_id']])){
                $info[$value['parent_id']] = array();
            };
            array_push($info[$value['parent_id']] , $value);
        }
        $all = array();
        foreach ($info as $key => $value) {

            $i = 0;

            $all[$i] = array();

            $all[$i] = $this->stack($info[$key],$key);

            dump($all[$i]);die;
            $i++;
        }
        dump($all);die;
    	//现在默认一个用户只有一个角色
//     	$role = 'teacher';
//     	$permission = M('role_right_relation')->field("right_id")->where(array('role_id'=>7))->select();
// //     	dump($permission);
// 		dump(implode(',', $permission));
//     	//这里显示模块权限
//     	$info = M("tb_right")->select();
//     	$info = \Home\Util\ToolsUtil::permissionTree($info);
//     	dump($info);
    	//添加权限信息
    	// $this->assign("info",$info);

        //
        //得到用户该有的列表

		$this->display();
    }
    /**
     * [stack description]
     * @param  array  $array    [子节点数组]
     * @param  [type] $parentid [子节点]
     * @return [type]           [maxfix]
     */
    private function stack($array=array() , $parentid){
        // var_dump("************".$parentid);
        if($parentid == 0){
            // echo "结束";
            return $array;
        }
        $data = M('privilege')->where(array('id' => $parentid, ))->select();
        dump($data);
        if(!is_array($data[$data['id']])){
            $data[$data['id']] = array();
        }
        array_push($data[$data['id']],$array);
        dump($data);die;
        $array = $data;
        $array = $this->stack($array['child'],$data['parent_id']);
        dump($array);
        return $array;
    }
}