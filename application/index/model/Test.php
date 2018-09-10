<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 2018/9/6
 * Time: 下午2:38
 */
namespace app\index\model;

use think\Model;

class Test extends Model {
    protected function initialize(){
        parent::initialize();
    }

    public function get_list(){
        $data = $this -> select() -> toArray();
        return $data;
    }

    public function insert_data($data){
        $this -> data($data);
        return $this -> save();
    }
}