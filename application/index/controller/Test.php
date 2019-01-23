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

    private $res_station = ['yes','no'];
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
        echo((1<<1 | 1<<2 | 1<<3) & 1<<3);
    }

    public function add(){
        $data = [
            'category_id' => '12',
            'category_ids' => '11,13',
            'title' => 'this is title',
            'content' => 'this is content',
            'image' => '/assets/img/avatar.png',
            'keywords' => 'keywords',
            'description' => 'description',
            'city' => 'city',
        ];
        $test_model = new tests();
        $res = $test_model -> insert_data($data);
        print_r($res);
    }

    public function test(){
        /*$is_sation = 'yes';
        dump(in_array($is_sation,$this -> res_station));
        exit;*/
        return $this -> view -> fetch();
    }

    public function delete(){
        $id = $this -> request -> param('id');
        $test_model = new tests();
        $res = $test_model -> m_destroy( $id );
        echo $res;
    }

    /**
     * 测试冒泡执行时间
     */
    public function bubble(){
        $start = microtime(true);

        $arr = array();
        for($i=0; $i<1000; $i++){
            $arr[$i] = rand(0,10000);
        }
        echo "数组的长度：".count($arr)."<hr>";
        $m_arr = $this -> bubble_arr( $arr );
        print_r($m_arr);
        $end = microtime(true);

        $time = ($end - $start) * 1000;
        echo "<hr>执行时间：".$time . "ms";
    }

    /**
     * 冒泡
     */
    private function bubble_arr( $arr ){

        for($i=0; $i<count($arr); $i++){
            for($j=0; $j<count($arr)-1; $j++){
                if( $arr[$j] > $arr[$j+1] ){
                    $str = $arr[$j];
                    $arr[$j] = $arr[$j+1];
                    $arr[$j+1] = $str;
                }
            }
        }
        return $arr;
    }

    public function jiaoben(){
        $url = 'https://www.gushiwen.org/';
        $info = $this -> get_curl_json($url);

        preg_match_all("/<a style=\"font-size:18px; line-height:22px; height:22px;\" href=\"(.*?)\" target=\"_blank\"><b>(.*?)<\/b><\/a>/si",$info,$data);
        echo "<pre>";
        print_r($data);
    }

    public function get_curl_json($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            print_r(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function redisindex(){
        $redis = new \redis();
        $redis -> connect('127.0.0.1', '6379');
        $redis -> auth('admin123');
        //$redis -> set('test2',"hello world");
        $result = $redis->get('test2');
        echo $result;

    }

    //遍历目录
    public function listmulu(){
        $dir = '/Users/didi/Desktop';
        $opdir = opendir($dir);
        if( $opdir ){
            while (($file = readdir( $opdir )) !== false){
                if( $file != '.' && $file != '..'){

                    $path = $dir.DIRECTORY_SEPARATOR.$file;
                    if( is_dir($path) ){
                        echo '这是一个目录：'.$path.'<br>';
                    }else{
                        echo '这是一个文件：'.$path.'<br>';
                    }

                }
            }
        }
    }

    public function erarray(){
        echo 'http://100.69.238.11:8000/sec/risk-gateway/common/risk_audit_callback?apiVersion=1.0.0_gz';
        echo '<hr />';
        exit;
        $data = array(array('jid'=>'1311','xid'=>'1606'),array('jid'=>'1302','xid'=>'1605'),array('jid'=>'1301','xid'=>'1604'));
        $arr = array_column($data,'xid','jid');
        echo '<pre>';
        print_r($arr);
    }
}