<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncTaskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tsync-task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'source_db_id') ?>

    <?= $form->field($model, 'aid_db_id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'sync_rule') ?>

    <?php // echo $form->field($model, 'sync_tables') ?>

    <?php // echo $form->field($model, 'start_timestamp') ?>

    <?php // echo $form->field($model, 'end_timestamp') ?>

    <?php // echo $form->field($model, 'execute_time') ?>

    <?php // echo $form->field($model, 'is_open') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'execute_rule') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
