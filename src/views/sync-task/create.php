<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncTask */

$this->title = '数据源配置';

use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="tsync-task-create">

    <div class="tsync-task-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'source_db_id')->dropDownList($sourcedbMap) ?>

        <?= $form->field($model, 'aid_db_id')->dropDownList($aiddbMap) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>