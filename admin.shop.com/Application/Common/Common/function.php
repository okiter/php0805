<?php
/**
 * 该文件的名字必须叫做 function.php
 */


/**
 * 从模型中获取错误信息拼装为ul
 * @param $model
 * @return string
 */
function showErrors($model)
{
    $errors = $model->getError();
    $msg = '<ul>';
    if(is_array($errors)){  //如果是数组,拼装
        foreach ($errors as $error) {
            $msg .= "<li>{$error}</li>";
        }
    }else{ //如果不是数组,直接拼装
        $msg .= "<li>{$errors}</li>";
    }

    $msg .= '</ul>';
    return $msg;
}


/**
 * 返回input数组中键值为column_key的列， 如果指定了可选参数index_key，那么input数组中的这一列的值将作为返回数组中对应值的键。
 * @param $rows
 * @param $column_key
 * @return array
 */
if(!function_exists('array_column')){
    function array_column ($rows,$column_key){
        $temp = array();
        foreach($rows as $row){
            $temp[] = $row[$column_key];
        }
        return $temp;
    }
}


/**
 * 根据传入的name和rows一个下拉列表的html
 * @param $name    表单元素的名字
 * @param $rows    下拉列表中需要的数据
 */
function arr2select($name,$rows,$defaultValue,$fieldValue='id',$fieldName='name'){
  $html = "<select name='{$name}' class='{$name}'>
            <option value=''>--请选择--</option>";
            foreach($rows as $row){
                //根据默认值比对每一行,从而生成selected='selected',然后在option中使用.
                $selected  = '';
                if($row[$fieldValue]==$defaultValue){
                    $selected = "selected='selected'";
                }
                $html.="<option value='{$row[$fieldValue]}' {$selected}>{$row[$fieldName]}</option>";
            }
    $html.="</select>";
    echo $html;
}
