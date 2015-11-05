<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/2
 * Time: 10:55
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller
{
    protected $model;

    public function _initialize()
    {
        //>>1.创建模型  该方法被构造函数调用.
        $this->model = D(CONTROLLER_NAME);
    }

    public function index()
    {
        //>>1.接收查询数据,准备查询条件
        $wheres = array();
        $keyword = I('get.keyword');
        if (!empty($keyword)) {
            $wheres['name'] = array('like', "%$keyword%");  // where name like $%keyword%
        }

        //>>2.使用模型中的select方法将数据查询出来
        /**
         * $pageResult{
         * $rows=>
         *   $pageHtml=>
         * }
         */
        $pageResult = $this->model->getPageResult($wheres);
        //>>3.需要将查询出来的数据分配到页面 assign
        $this->assign($pageResult);

        //将当前列表的url保存到cookie中,为了 删除,添加,修改状态,编辑 之后跳转到该地址
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        $this->assign('meta_title',$this->meta_title); //分配到列表页面上显示
        //>>4.选择页面显示 display
        $this->display('index');
    }

    public function add()
    {
        if (IS_POST) {
            //>>1.使用模型中的create方法收集并且验证, 自动完成
            if ($this->model->create() !== false) {
                //>>3.添加到数据库中
                if ($this->model->add() !== false) {
                    $this->success('添加成功!', cookie('__forward__'));
                    return;  //防止后面的代码执行.
                }
            }
            $this->error('操作失败!' . showErrors($this->model));
        } else {
            $this->assign('meta_title', '添加' . $this->meta_title);
            $this->display('edit');
        }
    }

    public function edit($id)
    {
        if (IS_POST) {
            //>>1.收集更新的数据
            if ($this->model->create() !== false) {
                if ($this->model->save() !== false) {
                    $this->success('更新成功!', cookie('__forward__'));
                    return;
                }
            }
            $this->error('操作失败!' . showErrors($this->model));
        } else {
            //>>2.根据id查询一行记录
            $row = $this->model->find($id);
            //>>3.将数据分配到页面上
            $this->assign($row);
            //>>4.选择视图页面显示
            $this->assign('meta_title', '编辑' . $this->meta_title);
            $this->display('edit');
        }
    }

    /**
     * 根据id将对应的记录的装改修改为指定的值
     * @param $id
     * @param int $status
     */
    public function changeStatus($id, $status = -1)
    {
        //>>1.直接使用SupplierModel中的changeStatus方法修改
        $result = $this->model->changeStatus($id, $status);
        //>>2.判定结果
        if ($result !== false) {
            $this->success('操作成功!', cookie('__forward__'));
        } else {
            $this->error('操作失败!');
        }
    }
}