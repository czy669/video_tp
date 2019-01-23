<?php

namespace app\index\model;

use app\admin\model\User;
use think\Db;
use think\Model;

class Videos extends Model
{
	// 设置当前模型对应的数据表名称 系统自动对应该模型名称的表名， 如果表名不同那么需要定义 protected $name = '表名';
	//protected $name = 'videos';
	
	// 设置返回数据集的对象名
	//protected $resultSetType = 'collection';
	
	//模型初始化
	protected function initialize()
	{
		parent::initialize();
	}
	
	//读取配置内容
	public function get_videos_list($where , $pagesize=20 , $order = 'id desc'){
		$data = $this -> where($where) -> order($order) ->  paginate( $pagesize );
		return $data;
	}
	
	/**
	 * 随机取出视频
	 */
	public function get_videos_rand($num,$cate_id=0,$area_id=0){
		$where['status'] = 1;
		if($cate_id){
			$where['cate_id'] = $cate_id;
		}
		if($area_id){
			$where['area_id'] = $area_id;
		}
		$data = $this -> where($where) -> orderRaw('rand()') -> limit($num) -> select();
		return $data;
	}
	
	/**
	 * 通过id读取视频信息
	 */
	public function get_videos_show($id){
		if(!$id){ return false;exit;}
		$where['id'] = $id;
		$data = $this -> where($where) -> find();
		$data = $data -> toArray();
		return $data;
	}
	
	/**
	 * 读取筛选列表
	 */
	public function get_select_list($table='area',$where=false,$field='*'){
		$table = 'fa_'.$table;
		$where['status'] = 1;
		$data = Db::table($table) -> where($where) -> select();
		return $data;
	}
	
	/**
	 * 给详情页打开是的时候点击量加1
	 */
	public function update_vides_id($id){
		if(!$id){ return false;exit;}
		$where['id'] = $id;
		$videos = new Videos();
		$videos -> where($where) -> setInc('hits');
	}
	
	/**
	 * 写入日志
	 */
	public function loginsert(){
		$request = request();
		$uid = $_COOKIE['uid']?$_COOKIE['uid']:0;
		$url = $request -> pathinfo();
		$url_name = $request -> action();
		$useragent = $request -> server('HTTP_USER_AGENT');
		$ip = $request -> server('REMOTE_ADDR');
		$createtime = time();
		$data['user_id'] = $uid;
		$data['url'] = $url;
		$data['from_url'] = $url_name;
		$data['ip'] = $ip;
		$data['useragent'] = $useragent;
		$data['createtime'] = $createtime;
		Db::table('fa_access_log') -> insert($data);
	}
}
