<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 2018/9/6
 * Time: 下午2:38
 */
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Test extends Model {

    //软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    //模型初始化
    protected static function init(){

    }

    public function get_list(){
        $data = $this -> select() -> toArray();
        return $data;
    }

    /**
     * @param $data
     * @return false|int
     */
    public function insert_data($data){
        $this -> data($data);
        return $this -> save();
    }

    /**
     * 软删除
     * @param $id
     * @return mixed
     */
    public function m_destroy( $id ){
        return $this -> destroy( $id );
    }


}