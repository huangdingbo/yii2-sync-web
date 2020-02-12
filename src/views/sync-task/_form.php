<?php

use dsj\components\assets\JsonEditorAsset;
use dsj\components\assets\LayuiAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

JsonEditorAsset::register($this);
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncTask */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tsync-task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'process_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sync_rule')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'execute_rule')->textarea(['rows' => 8,'style' => ['resize' => 'none']])
        ->label('执行规则' . ' <a href="#"  class="btn btn-primary btn-xs data-json">json工具</a>')?>

    <?= $form->field($model, 'sync_tables')->widget(Select2::className(),[
        'data' => $tables,
        'options' => ['multiple' => true, 'placeholder' => '请选择 ...'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $css = <<<CSS
        #tree_editor {
            width: 500px;
            height: 448px;
        }
        #json_editor {
            width: 500px;
            height: 448px;
        }
        #center {
            width: 62px;
            /*margin-left: 100px;*/
        }
        #right{

        }
        #left{
            transform: rotate(180deg);
        }
        #main{
            display: flex;
            align-items: center;
        }
CSS;
    $this->registerCss($css);

    $webPath = Yii::getAlias('@web');
    $js = <<<JS
  layui.config({
        base:'$webPath/layui/src/layuiadmin/' //静态资源所在路径
    }).use(['layer'],function() {
        var layer = layui.layer;
        
          $('.data-json').on('click',function() {
                let grandFather = $(this).parents()[1];
                let value = $(grandFather).find('textarea').text();
                let index = layer.open({
                  'type': 1,
                  'title': 'json工具',
                  'maxmin':true,
                  'area': ['800px','520px'],
                  'content' : '<div id="main">' +
                               '<div id="tree_editor"></div>' + 
                               '<div id="json_editor"></div>' + 
                               '</div>' + 
                               '<div id="footer_button">' +
                               '<a href="#" class="btn btn-primary btn-sm btn-block" id="save">保存</a>' +
                               '</div>',
                  'shadeClose': true,
                  success:function() {
                        const  editor1 = new JSONEditor(document.getElementById('tree_editor'), {
                        onChangeText: function (jsonString) {
                            editor2.set(JSON.parse(jsonString))
                            }
                        });               
                        // create editor 2
                        const  editor2 = new JSONEditor(document.getElementById('json_editor'),{
                             modes: ['code', 'text', 'form', 'view'],
                             mode: 'code',
                             ace: ace,
                             onChangeText: function (jsonString) {
                                editor1.set(JSON.parse(jsonString))
                            }
                        });                
                        let json = {a:1};
                        if (value){
                            json = JSON.parse(value);
                        }
                        editor1.set(json);
                        editor2.set(json);
                        
                        $('#save').on('click',function() {
                             let res = JSON.stringify(editor1.get(), null, 2);
                             if (res == '{}'){
                                 res = '';
                             }
                             $(grandFather).find('textarea').text(res)    
                             layer.close(index)                                               
                        })
                    },
                });
          })
    })
JS;
    $this->registerJs($js);
    ?>


</div>
