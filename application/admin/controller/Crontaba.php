<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 2018/10/31
 * Time: 下午3:26
 */
namespace app\admin\controller;

use app\admin\model\Videos;
use think\db;
use think\Exception;

class Crontaba {
    //精彩推荐
    private $jc = 'index1';
    //最新视频
    private $zx = 'index2';
    //最热视频
    private $zr = 'index3';

    protected $model = null;

    //当前路径
    private $path = ROOT_PATH . 'public';
    //初始化
    public function __construct(){
        $this -> model = new Videos();
    }

    //自动更新首页视频
    public function index(){

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

    //处理图片太大
    public function autoImgSize(){

        $page_row = db::table('fa_admin_log') -> where('id','1') -> field('admin_id') -> find();
        $id = $page_row['admin_id'];
        if($id == 1){ $id = 0;}
        //获取数据
        $data = $this -> get_video_list( $id );
        if(!$data){
            exit;
        }
        //执行处理
        foreach ($data as $k => $v){

            db::table('fa_admin_log') -> where('id','1') -> setField('admin_id', $v['id']);
            //处理图片
            $newcover = $this -> img_zoom( $v['cover'] );
            if( !$newcover ){
                continue;
            }
            db::table('fa_videos') -> where('id', $v['id']) -> setField('cover', $newcover);

        }

    }

    //获取数据
    private function get_video_list($id=1, $size=50){
        $data = db::table('fa_videos') -> where(array('id' => array('GT',$id))) -> field('id,cover') -> limit($size) -> select();
        return $data;
    }

    //处理图片
    public function img_zoom( $img ){
        $img = $this -> path . $img;
        //判断文件是否存在
        if( !file_exists( $img)){
            return false;
        }
        //生成新名称
        $name = $this -> img_name( $img );

        //处理图片
        try{
            $image = \think\Image::open( $img );
            if(!$image){ return false;}
            $image -> thumb(255,150) -> save( $name );
            if( !empty($image) ){
                return str_replace( $this -> path,'', $name);
            }
        }catch (Exception $e){

        }

    }

    //生成新的图片名称
    private function img_name( $name ){
        $name_arr = explode( '/', $name);
        $name_arr[ count( $name_arr )-1 ] = 'small_' . $name_arr[ count( $name_arr )-1 ];
        $sname = implode('/', $name_arr);
        return $sname;
    }
}