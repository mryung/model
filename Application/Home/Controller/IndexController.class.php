<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function pushStack($child=array(),$array=array(),$parentid){
        foreach ($array as $key => $value) {
            if($value['id'] == $parentid){ //根据子节点查到父节点
                if(!is_array($value['child'])){
                   $value['child'] = array();
                }
                array_push($value['child'],$child);
                $child = $this->pushStack($value,$array,$value['parent_id']);
            }
        }
        return $child;
    }



    public function index(){

        $data = M('view_privilege')->where('user_id=2')->select();

        $info = array();

        foreach ($data as $key => $value) {
            if(!is_array($info[$value['parent_id']])){
                $info[$value['parent_id']] = array();
            };
            array_push($info[$value['parent_id']] , $value);
        }


        $all = array();
        $i = 0;
        foreach ($info as $key => $value) {

            array_push($all,$this->stack($info[$key],$key));

        }

        $this->assign("info",$all);

		$this->display();
    }
    /**
     * [stack description]
     * @param  array  $array    [子节点数组]
     * @param  [type] $parentid [子节点]
     * @return [type]           [maxfix]
     */
    private function stack($array=array() , $parentid){
        if($parentid == 0){
            return $array;
        }
        $data = M('privilege')->where(array('id' => $parentid, ))->find();

        if(!is_array($data['child'])){
            $data['child'] = array();
        }
        $data['child'] = $array;

        $array = $data;

        $array = $this->stack($array,$data['parent_id']);

        return $array;
    }
}