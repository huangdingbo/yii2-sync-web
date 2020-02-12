<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncDb */

$this->title = '修改连接' . $model->name;
?>
<div class="tsync-db-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

