<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/14
 * Time: 11:51
 */

namespace Home\Model;


use Think\Model;

class ArticleCategoryModel extends Model
{


    /**
     * 查询出帮助类的分类
     * @return mixed
     */
    public function getHelpArticleCategory(){
        $helpArticleCategorys = S('helpArticleCategorys');
        if(empty($helpArticleCategorys)){
            $helpArticleCategorys = $this->field('id,name')->where(array('is_help'=>1,'status'=>1))->select();
            S('helpArticleCategorys',$helpArticleCategorys);
        }
        return $helpArticleCategorys;
    }
}