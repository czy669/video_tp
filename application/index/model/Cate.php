<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Cate extends Model
{
	//模型初始化
	protected function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * 读取筛选列表
	 */
	public function get_cate_list(){
		$where['status'] = 1;
		$data = $this -> where($where) -> select();
		return $data;
	}
	
	/**
	 * 读取分类详情
	 * @param unknown $id
	 * @return unknown
	 */
	public function get_cate_by_id($id){
		$where['status'] = 1;
		$where['id'] = $id;
		$data = $this -> where($where) -> find();
		return $data;
	}
	
	/*
	 * 
	 */
	public function get_cate_name_by_id($id){
		$where['status'] = 1;
		$where['id'] = $id;
		$filed = 'title';
		$data = $this -> where($where) ->field($filed)->find();
		return $data['title'];
	}
}