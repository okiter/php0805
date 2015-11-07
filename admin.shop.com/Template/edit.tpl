<extend name="Common:edit"/>
<block name="form">
    <form method="post" action="{:U()}">
        <table cellspacing="1" cellpadding="3" width="100%">
            <?php  foreach($fields as $field):
               if($field['key']=='PRI'){
                    continue;
               }
             ?>
            <tr>
                <td class="label"><?php echo $field['comment']?></td>
                <td>
                    <?php
                        //目的: 根据每个字段的注解中指定的表单元素的类型,生成不同的表单元素
                        //1. 获取每个注解中的表单元素类型
                       if($field['input_type']=='text'){
                            echo "<textarea name=\"{$field['field']}\" cols=\"60\" rows=\"4\">{\${$field['field']}}</textarea>\r\n";
                       }elseif($field['input_type']=='file'){
                            echo "<input type=\"file\" name=\"{$field['field']}\"/>";
                       }elseif($field['input_type']=='radio'){
                           //根据可选值生成多个单选按钮
                            if($field['field']=='status'){  //对status单独生成
                                foreach($field['option_values'] as $key=>$value){
                                    echo "<input type=\"radio\" class=\"status\" value=\"{$key}\" name=\"{$field['field']}\"/>{$value}";
                                }
                            }else{
                                foreach($field['option_values'] as $key=>$value){
                                     echo "<input type=\"radio\" value=\"{$key}\" name=\"{$field['field']}\"/> {$value}";
                                }
                            }
                        }else{
                            if($field['field']=='sort'){   //对sort字段单独生成一个效果
                                echo "<input type=\"text\" name=\"{$field['field']}\" maxlength=\"60\" value=\"{\$sort|default=20}\">";
                            }else{
                                echo "<input type=\"text\" name=\"{$field['field']}\" maxlength=\"60\" value=\"{\${$field['field']}}\">";
                            }

                        }
                    ?>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <?php endForeach;?>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden"  name="id" value="{$id}" />
                    <input type="submit" class="button ajax-post" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</block>