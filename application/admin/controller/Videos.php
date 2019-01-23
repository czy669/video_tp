<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\common\model\Category as CategoryModel;

/**
 * 视频信息管理
 *
 * @icon fa fa-circle-o
 */
class Videos extends Backend
{
    
    /**
     * Videos模型对象
     * @var \app\admin\model\Videos
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Videos');
	    $this->view->assign("typeList", CategoryModel::getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['area','cate'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['area','cate'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            
            foreach ($list as $row) {
                $row->getRelation('area')->visible(['title']);
				$row->getRelation('cate')->visible(['title']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);
			
            return json($result);
        }
        return $this->view->fetch();
    }
	/**
	 * 回收站
	 */
	public function recyclebin()
	{
		//设置过滤方法
		$this->request->filter(['strip_tags']);
		if ($this->request->isAjax()) {
			list($where, $sort, $order, $offset, $limit) = $this->buildparams();
			$total = $this->model
				->onlyTrashed()
				->where($where)
				->order($sort, $order)
				->count();
			
			$list = $this->model
				->onlyTrashed()
				->where($where)
				->order($sort, $order)
				->limit($offset, $limit)
				->select();
			
			$result = array("total" => $total, "rows" => $list);
			
			return json($result);
		}
		return $this->view->fetch();
	}
	
	/**
	 * 添加
	 */
	public function add()
	{
		if ($this->request->isPost()) {
			$params = $this->request->post("row/a");
			if ($params) {
				if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
					$params[$this->dataLimitField] = $this->auth->id;
				}
				try {
					//是否采用模型验证
					if ($this->modelValidate) {
						$name = basename(str_replace('\\', '/', get_class($this->model)));
						$validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
						$this->model->validate($validate);
					}
					$result = $this->model->allowField(true)->save($params);
					if ($result !== false) {
						$this->success();
					} else {
						$this->error($this->model->getError());
					}
				} catch (\think\exception\PDOException $e) {
					$this->error($e->getMessage());
				}
			}
			$this->error(__('Parameter %s can not be empty', ''));
		}
		
		return $this->view->fetch();
	}
	
	/**
	 * 编辑
	 */
	public function edit($ids = NULL)
	{
		$row = $this->model->get($ids);
		
		if (!$row)
			$this->error(__('No Results were found'));
		$adminIds = $this->getDataLimitAdminIds();
		if (is_array($adminIds)) {
			if (!in_array($row[$this->dataLimitField], $adminIds)) {
				$this->error(__('You have no permission'));
			}
		}
		if ($this->request->isPost()) {
			$params = $this->request->post("row/a");
			if ($params) {
				try {
					//是否采用模型验证
					if ($this->modelValidate) {
						$name = basename(str_replace('\\', '/', get_class($this->model)));
						$validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
						$row->validate($validate);
					}
					$result = $row->allowField(true)->save($params);
					if ($result !== false) {
						$this->success();
					} else {
						$this->error($row->getError());
					}
				} catch (\think\exception\PDOException $e) {
					$this->error($e->getMessage());
				}
			}
			$this->error(__('Parameter %s can not be empty', ''));
		}
		$this->view->assign("row", $row);
		return $this->view->fetch();
	}
	
	/**
	 * 删除
	 */
	public function del($ids = "")
	{
		if ($ids) {
			$pk = $this->model->getPk();
			$adminIds = $this->getDataLimitAdminIds();
			if (is_array($adminIds)) {
				$count = $this->model->where($this->dataLimitField, 'in', $adminIds);
			}
			$list = $this->model->where($pk, 'in', $ids)->select();
			$count = 0;
			foreach ($list as $k => $v) {
				$count += $v->delete();
			}
			if ($count) {
				$this->success();
			} else {
				$this->error(__('No rows were deleted'));
			}
		}
		$this->error(__('Parameter %s can not be empty', 'ids'));
	}
	
	/**
	 * 真实删除
	 */
	public function destroy($ids = "")
	{
		$pk = $this->model->getPk();
		$adminIds = $this->getDataLimitAdminIds();
		if (is_array($adminIds)) {
			$count = $this->model->where($this->dataLimitField, 'in', $adminIds);
		}
		if ($ids) {
			$this->model->where($pk, 'in', $ids);
		}
		$count = 0;
		$list = $this->model->onlyTrashed()->select();
		foreach ($list as $k => $v) {
			$count += $v->delete(true);
		}
		if ($count) {
			$this->success();
		} else {
			$this->error(__('No rows were deleted'));
		}
		$this->error(__('Parameter %s can not be empty', 'ids'));
	}
	
	/**
	 * 还原
	 */
	public function restore($ids = "")
	{
		$pk = $this->model->getPk();
		$adminIds = $this->getDataLimitAdminIds();
		if (is_array($adminIds)) {
			$this->model->where($this->dataLimitField, 'in', $adminIds);
		}
		if ($ids) {
			$this->model->where($pk, 'in', $ids);
		}
		$count = 0;
		$list = $this->model->onlyTrashed()->select();
		foreach ($list as $index => $item) {
			$count += $item->restore();
		}
		if ($count) {
			$this->success();
		}
		$this->error(__('No rows were updated'));
	}
	
	/**
	 * 批量更新
	 */
	public function multi($ids = "")
	{
		$ids = $ids ? $ids : $this->request->param("ids");
		if ($ids) {
			if ($this->request->has('params')) {
				parse_str($this->request->post("params"), $values);
				$values = array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
				if ($values) {
					$adminIds = $this->getDataLimitAdminIds();
					if (is_array($adminIds)) {
						$this->model->where($this->dataLimitField, 'in', $adminIds);
					}
					$count = 0;
					$list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
					foreach ($list as $index => $item) {
						$count += $item->allowField(true)->isUpdate(true)->save($values);
					}
					if ($count) {
						$this->success();
					} else {
						$this->error(__('No rows were updated'));
					}
				} else {
					$this->error(__('You have no permission'));
				}
			}
		}
		$this->error(__('Parameter %s can not be empty', 'ids'));
	}
	
	/**
	 * 导入
	 */
	protected function import()
	{
		$file = $this->request->request('file');
		if (!$file) {
			$this->error(__('Parameter %s can not be empty', 'file'));
		}
		$filePath = ROOT_PATH . DS . 'public' . DS . $file;
		if (!is_file($filePath)) {
			$this->error(__('No results were found'));
		}
		$PHPReader = new \PHPExcel_Reader_Excel2007();
		if (!$PHPReader->canRead($filePath)) {
			$PHPReader = new \PHPExcel_Reader_Excel5();
			if (!$PHPReader->canRead($filePath)) {
				$PHPReader = new \PHPExcel_Reader_CSV();
				if (!$PHPReader->canRead($filePath)) {
					$this->error(__('Unknown data format'));
				}
			}
		}
		
		//导入文件首行类型,默认是注释,如果需要使用字段名称请使用name
		$importHeadType = isset($this->importHeadType) ? $this->importHeadType : 'comment';
		
		$table = $this->model->getQuery()->getTable();
		$database = \think\Config::get('database.database');
		$fieldArr = [];
		$list = db()->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?", [$table, $database]);
		foreach ($list as $k => $v) {
			if ($importHeadType == 'comment') {
				$fieldArr[$v['COLUMN_COMMENT']] = $v['COLUMN_NAME'];
			} else {
				$fieldArr[$v['COLUMN_NAME']] = $v['COLUMN_NAME'];
			}
		}
		
		$PHPExcel = $PHPReader->load($filePath); //加载文件
		$currentSheet = $PHPExcel->getSheet(0);  //读取文件中的第一个工作表
		$allColumn = $currentSheet->getHighestDataColumn(); //取得最大的列号
		$allRow = $currentSheet->getHighestRow(); //取得一共有多少行
		$maxColumnNumber = \PHPExcel_Cell::columnIndexFromString($allColumn);
		for ($currentRow = 1; $currentRow <= 1; $currentRow++) {
			for ($currentColumn = 0; $currentColumn < $maxColumnNumber; $currentColumn++) {
				$val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
				$fields[] = $val;
			}
		}
		$insert = [];
		for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
			$values = [];
			for ($currentColumn = 0; $currentColumn < $maxColumnNumber; $currentColumn++) {
				$val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
				$values[] = is_null($val) ? '' : $val;
			}
			$row = [];
			$temp = array_combine($fields, $values);
			foreach ($temp as $k => $v) {
				if (isset($fieldArr[$k]) && $k !== '') {
					$row[$fieldArr[$k]] = $v;
				}
			}
			if ($row) {
				$insert[] = $row;
			}
		}
		if (!$insert) {
			$this->error(__('No rows were updated'));
		}
		try {
			$this->model->saveAll($insert);
		} catch (\think\exception\PDOException $exception) {
			$this->error($exception->getMessage());
		}
		
		$this->success();
	}
}
