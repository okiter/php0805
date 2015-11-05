namespace Admin\Model;


use Think\Model;

class <?php echo $name ?>Model extends BaseModel
{
    // 自动验证定义
    protected $_validate = array(
        <?php foreach($fields as $field){    //根据表中的字段生成验证规则
              //主键和可以为空的不需要生成验证规则
              if($field['key']=='PRI' || $field['null']=='YES'){
                    continue;
              }
             echo  "array('{$field['field']}','require','{$field['comment']}不能够为空!'),\r\n";
         }?>
    );


}