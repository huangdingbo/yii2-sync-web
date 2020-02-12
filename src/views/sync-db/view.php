<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncDb */

$this->title = '查看:' . $model->name;
?>
<div class="tsync-db-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'type',
                'value' => function($dataProvider){
                    return $dataProvider->type == 1 ? '源数据库' : '目标数据库';
                },
            ],
            [
                'attribute' => 'db_type',
                'value' => function($dataProvider){
                    return $dataProvider->db_type == 0 ? 'mysql' : '其他';
                },
            ],
            'host',
            'db_name',
            'port',
            'username',
            'password',
            'connect_charset',
        ],
    ]) ?>

</div>



