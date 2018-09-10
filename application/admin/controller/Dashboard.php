<?php

namespace app\admin\controller;

use app\admin\model\User;
use app\common\controller\Backend;
use think\Config;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++)
        {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        
	    //读取服务器信息
	    $this -> server_info();
        //实例化用户模块
        $user = new User();
        //今日注册
	    $day_reg_where['createtime'] = array('gt',strtotime(date('Y-m-d',time())));
	    $day_reg = $user -> user_count($day_reg_where);
	    //今日登陆
	    $day_login_where['logintime'] = array('gt',strtotime(date('Y-m-d',time())));
	    $day_login = $user -> user_count($day_login_where);
	    
        $this->view->assign([
            'totaluser'        => $user -> count('id'),
            'totalviews'       => $user -> count_log('id'),
            'totalorder'       => 32143,
            'totalorderamount' => 174800,
            'todayuserlogin'   => $day_login,
            'todayusersignup'  => $day_reg,
            'todayorder'       => 2324,
            'unsettleorder'    => 132,
            'sevendnu'         => '80%',
            'sevendau'         => '32%',
            'paylist'          => $paylist,
            'createlist'       => $createlist,
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode
        ]);

        return $this->view->fetch();
    }
	
    /**
     * 读取服务器信息
     */
    public function server_info(){
	   
    }
}
