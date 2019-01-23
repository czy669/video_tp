<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Trans extends Model
{
	//模型初始化
	protected function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * 通过视频id 读取 对应标签
	 */
	public function get_trans_by_vid($vid){
		$where['v_id'] = $vid;
		$data = $this -> where($where) -> select() ->toArray();
		return $data;
	}
	
	/**
	 * 读取热门标签
	 */
	public function get_trans_hots($num=6){
		$data = $this -> field('name,count(name) as num') -> order('hots desc') -> group('name') -> limit($num) -> select() -> toArray();
		return $data;
	}
	
	/**
	 * 通过标签名称读取视频id
	 */
	public function get_trans_by_name($name){
		$where['name'] = array('like',$name);
		$data = $this -> where($where) -> order('hots desc') -> select() ->toArray();
		return $data;
	}
}