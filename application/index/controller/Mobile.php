<?php

namespace app\index\controller;

use app\common\controller\Frontend;
// 引用分类模型
use app\common\model\Category as CategoryModel;
// 引用videos模型
use app\index\model\Videos;
// 地区模型
use app\index\model\Cate;
// 内容模型
use app\index\model\Area;
// 标签模型
use app\index\model\Trans;
use think\Cache;

class Mobile extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';
    protected $videos = null;

    //控制器初始化
	public function _initialize()
	{
		parent::_initialize();
		
		if($this -> auth -> isLogin()){
			$this -> assign('userinfo',$this -> auth -> getUserinfo());
		}else{
			$_COOKIE['uid'] = 0;
		}
		//实例化videos对象
		$this -> videos = new Videos();
		
		//写日志
		$this -> videos -> loginsert();

		//获取当前的请求信息
		$this -> request = request();
	}

    /**
     * @return mixed
     * 手机端首页
     */
	public function index(){
	    $this -> assign('title','首页');
		//读取首页数据
        $data = $this -> video_list_data();

		$this -> assign('data',$data);
		return $this -> fetch('index');
	}

    /**
     * @return string
     * @throws \think\Exception
     * 手机端详情页
     */
	public function show(){
		//获取视频id
		$id = $this -> request ->param('id');

        $videos = new Videos();
		//读取视频信息
        $data = $videos -> get_videos_show( $id );
		$this -> assign('data',$data);

		return $this -> view -> fetch();
	}

    /**
     * 手机端首页数据
     */
    private function video_list_data(){
        //先取缓存数据
        //echo Cache::rm('mobile_video_data');
        //$data = cache('mobile_video_data');
        $videos = new Videos();
        $where['status'] = 1;   //状态
        $pagesize = 100;    //显示数目
        $data = $videos -> get_videos_rand($pagesize ) -> toArray();
        //将数据保存到缓存
        //cache('mobile_video_data',$data,'3600');
        return $data;
    }

	public function crontab_id(){
        $this -> videos -> update_vides_id('100');
    }


}