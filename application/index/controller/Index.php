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

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    //控制器初始化
	public function _initialize()
	{
		parent::_initialize();
		if($this -> auth -> isLogin()){
			$this -> assign('userinfo',$this -> auth -> getUserinfo());
		}else{
			$_COOKIE['uid'] = 0;
		}
		//底部
		$this -> get_footer_show();
		
		//实例化videos对象
		$this -> videos = new Videos();
		
		//写日志
		$this -> videos -> loginsert();
		
		//获取当前的请求信息
		$this -> request = request();
		
		//将控制器名称
		$this -> assign('controller', strtolower($this -> request -> controller()));
		
		//读取导航条
		$this -> get_header();
	}
	
	/**
	 * @return string
	 * @throws \think\Exception
	 * 首页控制器
	 */
    public function index()
    {
    	//定义页面名称
    	$this -> assign('title','首页');
    	
    	//读取banenr
	    $type = 'banner';
	    $banner = CategoryModel::getCategoryArray($type);
	    $this -> assign('banner',$banner);
	    
	    //读取首页内容配置
	    $type_arr = CategoryModel::getTypeList();
	    //处理配置获取对应信息
	    $i = 0;
	    foreach ($type_arr as $tk => $tv){
		    if(strstr($tk,'index')){
			    $data[$i]['type_name'] = $tv;
			    $data[$i]['type'] = CategoryModel::getCategoryArray($tk);
			    $where['type'] = $tk;
			    $videos_data = $this -> videos -> get_videos_list( $where , 10);
			    $data[$i]['data'] = $videos_data;
			    $i++;
		    }
	    }

	    $this -> assign('data',$data);
	    //导航
	    //关联地区
	    $this -> assign('area_list',$this -> _area_list());
	    //关联内容
	    $this -> assign('cate_list',$this -> _cate_list());
	    //读取首页热门标签
	    $this -> assign('trans_list',$this -> _trans_list());
	    
        return $this -> view -> fetch();
    }
    
    /**
     * 视频列表
     */
    public function list(){
    	
    	$area_id = $this -> request -> param('area_id') ?? 0;//地区
	    $cate_id = $this -> request -> param('cate_id') ?? 0;//分类
	    $sort = $this -> request -> param('sort') ?? 0;//排序
	
	    //搜索关键词
	    $key = $this -> request -> param('key') ?? 0;
	    if($key){
	    	$where['title'] = array('like', $key);
	    	$this -> assign('key',$key);
	    }
	    
	    $url = '/index/index/list.html?list';
	    $sort_url =  $url;
	    $order = 'id desc';
	    if($sort){
		    $url .= '&sort='.$sort;
		    if($sort == '2'){
			    $order = 'hits desc';
		    }
	    }
	    
	    if($area_id){
		    $cate_url = $url.'&area_id='.$area_id;
		    $sort_url = $sort_url.'&area_id='.$area_id;
		    //补充条件
		    $where['area_id'] = $area_id;
	    }else{
		    $cate_url = $url;
	    }
	    if($cate_id){
		    $area_url = $url.'&cate_id='.$cate_id;
		    $sort_url = $sort_url.'&cate_id='.$cate_id;
		    //补充条件
		    $where['cate_id'] = $cate_id;
	    }else{
		    $area_url = $url;
	    }
	    
	    
	    $this -> assign('area_id',$area_id);
	    $this -> assign('cate_id',$cate_id);
	    $this -> assign('sorts',$sort);
	    $this -> assign('cate_url',$cate_url);
	    $this -> assign('area_url',$area_url);
	    $this -> assign('sort_url',$sort_url);
	    //定义页面名称
	    $this -> assign('title','列表');
	    
    	//读取筛选列表
	    $select_area= array('name'=>'地区','url'=>$url);
	    $select_cate= array('name'=>'分类','url'=>$url);
	    $select_area['data'] = $this -> videos -> get_select_list('area');
	    $select_cate['data'] = $this -> videos -> get_select_list('cate');
	
	    $this -> assign('select_area',$select_area);
	    $this -> assign('select_cate',$select_cate);
	    
	    //视频列表
	    $where['status'] = '1';
	    $data = $this -> videos -> get_videos_list( $where , 60 , $order);
	    // 获取分页显示
	    $page = $data->render();
	    
	    $this -> assign('page',$page);
	    $this -> assign('data',$data);
	    return $this->view->fetch();
    }
	
	//关联内容
    private function _cate_list(){
    	
    	$cate_model = new Cate();
    	$data = $cate_model -> get_cate_list();
    	return $data;
    }
	
	//关联地区
    private function _area_list(){
    	$area_model = new Area();
    	$data = $area_model -> get_area_list();
    	return $data;
    }
	
	//读取首页热门标签
    private function _trans_list(){
	    $trans_model = new Trans();
	    $trans = $trans_model -> get_trans_hots();
	    return $trans;
    }
    
	/**
	 * 详情页面
	 */
    public function show(){
	    //获取视频id
	    $id = $this -> request ->param('id');
	    
	    //读取视频信息
	    $data = $this -> videos -> get_videos_show($id);
	    
	    //点击量加1
	    $this -> videos -> update_vides_id($id);
	    
	    //关联内容
	    $cate_model = new Cate();
	    $data['cate_name'] = $cate_model -> get_cate_name_by_id($data['cate_id']);
	    
	    //关联地区
	    $area_model = new Area();
	    $data['area_name'] = $area_model -> get_area_name_by_id($data['area_id']);
	    
	    //关联标签
	    $trans_model = new Trans();
	    $trans = $trans_model -> get_trans_by_vid( $id );
	    //重写标签
	    $data['tag'] = '';
	    foreach ($trans as $v){
	    	$data['tag'] .= $v['name'].'，';
	    }
	    $data['tag'] = rtrim($data['tag'],'，');//去掉结尾符号
	    
	    //视频右边列表
	    $where['area_id'] = $data['area_id'];
	    $where['status'] = 1;
	    $order = "hits desc";
	    $data_left = $this -> videos -> get_videos_list($where,6,$order);
	    $this -> assign('data_left',$data_left);
	    
	    //视频推荐列表
	    $data_list = $this -> videos -> get_videos_rand(10);
	    $this -> assign('data_list',$data_list);
	    
	    //定义页面名称
	    $this -> assign('title',$data['title']);
	    $url_path = 'http://'.$this -> request -> server('HTTP_HOST').'/index/index/share.html?id='.$data['id'];
	    $this -> assign('url_path',$url_path);
	
	    $this -> assign('data',$data);
	    return $this->view->fetch();
    }
	
    /**
     * 底部信息
     */
    public function get_footer_show(){
	    //底部信息
	    $footer = CategoryModel::getCategoryArray('footer');
	    if(!empty($footer)){
		    $footer = array_column($footer,'content','type');
		    $this -> assign('footer',$footer);
	    }
    }
    
    /**
     * 读取导航条
     */
    public function get_header(){
	    //读取导航条
	    $type = 'header';
	    $data = CategoryModel::getCategoryArray($type);
	    $this -> assign('header',$data);
    }
    
    /**
     * 分享页面单独显示视频
     */
	public function share(){
		
		//获取视频id
		$id = $this -> request ->param('id');
		
		//读取视频信息
		$data = $this -> videos -> get_videos_show($id);
		$this -> assign('data',$data);
		
		return $this->view->fetch();
	}
}
