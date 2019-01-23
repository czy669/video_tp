<?php

namespace app\admin\model;

use think\Model;

class Trans extends Model
{
    // 表名
    protected $name = 'trans';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];

    /**
     * 标签模型插入数据
     * @param $name     -   标签名称
     * @param $vid      -   视频id
     * @param $hots     -   标签热度、点击量
     * @return bool     -   返回值 true or false
     */
    public function add($name, $vid, $hots){
        $data = [
            'name' => $name,
            'v_id' => $vid,
            'hots' => $hots,
            'createtime' => time(),
        ];
        $this -> data( $data );
        $res = $this -> save();
        if($res){
            return true;
        }else{
            return false;
        }
    }







}
