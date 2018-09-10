<?php

namespace app\admin\model;

use think\Model;

class Videos extends Model
{
    // 表名
    protected $name = 'videos';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'play_time_text',
        'status_text'
    ];
    

    
    public function getStatusList()
    {
    	$data = array('1' => '显示','0' => '隐藏');
        return $data;
    }     


    public function getPlayTimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['play_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setPlayTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


    public function area()
    {
        return $this->belongsTo('Area', 'area_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function cate()
    {
        return $this->belongsTo('Cate', 'cate_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
