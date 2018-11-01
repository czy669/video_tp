<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 2018/10/31
 * Time: 下午3:26
 */
namespace app\admin\controller;
use app\admin\model\Videos;

class Crontaba {

    //精彩推荐
    private $jc = 'index1';
    //最新视频
    private $zx = 'index2';
    //最热视频
    private $zr = 'index3';

    protected $model = null;

    //自动更新首页视频
    public function index(){
        $this -> model = new Videos();
        //重置最新视频
        $zx_where['type'] = $this -> zx;
        $zx_data['type'] = '';
        //将之前的最新视频重置
        $this -> model -> update_video_list($zx_where,'');
        //查询最新视频
        $zx_ids = $this -> model -> get_zx_video_list(10);
        foreach ($zx_ids as $zk => $zv) {
            $zx_ids[$zk] = $zv['id'];
        }
        //重置最新视频
        echo $this -> model -> update_video_list(array('id' => array("in",$zx_ids)), $this -> zx);


        //重置最热视频
        $zr_where['type'] = $this -> zr;
        $zr_data['type'] = '';

        //将之前的最热视频重置
        $this -> model -> update_video_list($zr_where,'');
        //查询最新视频
        $zr_ids = $this -> model -> get_zr_video_list(10);
        foreach ($zr_ids as $zk => $zv) {
            $zr_ids[$zk] = $zv['id'];
        }
        //重置最新视频
        echo $this -> model -> update_video_list(array('id' => array("in",$zr_ids)), $this -> zr);

    }
}