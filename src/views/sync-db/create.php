<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncDb */

$this->title = '创建连接';
?>
<div class="tsync-db-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
