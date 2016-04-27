<?php
namespace Home\Controller;

use \Home\Controller\BasicController;

class IndexController extends BasicController {
    public function pushStack($child=array(),$array=array(),$parentid){
        foreach ($array as $key => $value) {
            if($value['id'] == $parentid){ //����ӽڵ�鵽���ڵ�
                if(!is_array($value['child'])){
                   $value['child'] = array();
                }
                array_push($value['child'],$child);
                $child = $this->pushStack($value,$array,$value['parent_id']);
            }
        }
        return $child;
    }

    public function buildTree($info){
        $array = array();
        foreach ($info as $key => $value) {
            if(!is_array($array[$value['parent_id']])){
                $array[$value['parent_id']] = array();
            }
            array_push($array[$value['parent_id']],$value);
        }
        return $array;
    }

    public function buildParentsTree($all,$info){
        $array = array();
        foreach ($info as $key => $value) {
            foreach ($all as $key1 => $value1) {
                if($key == $value1['id']){
                    $value1['child'] = $value;
                    array_push($array,$value1);

                }
            }
        }
        return $array;
    }

    public function index(){

        //�õ��û���ӵ�е�Ȩ�ޣ�����Ȩ��
        $data = M('view_privilege')->where('user_id='.session("userid"))->select();
        $all = M('privilege')->select();
        $data  = $this->buildTree($data);
        // dump($data);die;
        $data = $this->buildParentsTree($all,$data);

        $data = $this->buildTree($data);

        $all = $this->buildParentsTree($all,$data);

        // $info = array();

        // //����ͬ�������װ��һ��
        // foreach ($data as $key => $value) {
        //     if(!is_array($info[$value['parent_id']])){
        //         $info[$value['parent_id']] = array();
        //     };
        //     array_push($info[$value['parent_id']] , $value);
        // }


        // $all = array();
        // $i = 0;

        // //�õ�һ����
        // foreach ($info as $key => $value) {

        //     array_push($all,$this->stack($info[$key],$key));

        // }
        $this->assign("info",$all);

		$this->display();
    }

    /**
     * [stack description]
     * @param  array  $array    [�ӽڵ�����]
     * @param  [type] $parentid [�ӽڵ�]
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
        $data["child"] = $array;

        $array = $data;

        $array = $this->stack($array,$data['parent_id']);

        return $array;
    }
}