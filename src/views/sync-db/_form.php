<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncDb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tsync-db-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([1 => '源数据库',2 => '目标数据库']) ?>

    <?= $form->field($model, 'db_type')->dropDownList([0 => 'mysql']) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'db_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'port')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'connect_charset')->dropDownList(['utf8' => 'utf8']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
