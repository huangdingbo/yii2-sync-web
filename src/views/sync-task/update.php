<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncTask */

$this->title = '拉取配置:' . $model->name;
?>
<div class="tsync-task-update">

    <?= $this->render('_form', [
        'model' => $model,
        'tables' => $tables
    ]) ?>

</div>

