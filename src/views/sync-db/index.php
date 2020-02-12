<?php

use dsj\components\grid\ResponsiveActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use dsj\components\grid\ResponsiveGridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sync\models\TSyncDbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '连接配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsync-db-index">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
                 <?= Html::button('创建连接', ['class' => 'btn btn-success data-create','url' => Url::to(['create'])]) ?>
        </p>

    <?= ResponsiveGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>"首页",
            'prevPageLabel'=>'上一页',
            'nextPageLabel'=>'下一页',
            'lastPageLabel'=>'尾页',
        ],
        'columns' => [
            'name',
            [
                    'attribute' => 'type',
                    'value' => function($dataProvider){
                        return $dataProvider->type == 1 ? '源数据库' : '目标数据库';
                    },
                    'filter' => [1 => '源数据库',2 => '目标数据库'],
            ],
            [
                'attribute' => 'db_type',
                'value' => function($dataProvider){
                    return $dataProvider->db_type == 0 ? 'mysql' : '其他';
                },
                'filter' => [0 => 'mysql'],
            ],
            'host',
            'db_name',
            'failed_num',
            //'port',
            //'username',
            //'password',
            //'connect_charset',

            [
                'class' => ResponsiveActionColumn::className(),
                'template' => '{view} {update-source} {update} {test-connect} {delete}',
                'header' => '操作',
                'buttons' => [
                    'test-connect' => function ($url, $model, $key) {
                        return Html::a('测试连接',$url, [
                            'class' => 'btn btn-success btn-sm data-update-source',
                        ]);
                    },
                ],
            ],
    ],
    ]); ?>
</div>
