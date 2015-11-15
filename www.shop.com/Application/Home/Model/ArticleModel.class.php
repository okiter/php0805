<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/14
 * Time: 14:39
 */

namespace Home\Model;


use Think\Model;

class ArticleModel extends Model
{

    public function getHelpArticle(){
        $helpArticles  = S('helpArticle');
        if(empty($helpArticles)){
//            $sql = "select a.id,a.name,a.article_category_id from article as a join article_category as ac on a.article_category_id=ac.id where ac.is_help = 1";
//            $helpArticles = $this->query($sql);
            $this->field('a.id,a.name,a.article_category_id')->alias('a')->join("__ARTICLE_CATEGORY__ as ac on a.article_category_id=ac.id")->where(array('ac.is_help'=>1,'a.status'=>1));
            $helpArticles = $this->select();
           S('helpArticle',$helpArticles);
        }
        return $helpArticles;
    }

    /**
     * 获取指定数量的快报内容
     */
    public function getNews($num = 8){
        return $this->where(array('article_category_id'=>6,'status'=>1))->order('inputtime desc')->select();
    }
}