<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 2018/9/6
 * Time: 上午11:22
 */
namespace app\index\controller;

use app\common\controller\Frontend;
use app\index\model\Test as tests;

class Test extends Frontend {

    //控制器初始化
    public function _initialize(){

    }

    public function index(){
        $test_model = new tests();
        $data = $test_model -> get_list();
        echo '<pre>';
        print_r($data);
    }

    public function edit(){
        echo 123;
    }
}