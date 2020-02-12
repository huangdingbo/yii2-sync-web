<?php

use dsj\bgtask\models\BgTask;
use dsj\components\grid\ResponsiveActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use dsj\components\grid\ResponsiveGridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sync\models\TSyncTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = '数据同步配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsync-task-index">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
                 <?= Html::button('创建数据源配置', ['class' => 'btn btn-success data-create','url' => Url::to(['create'])]) ?>
        </p>

   <div style="overflow-x:auto">
       <?= ResponsiveGridView::widget([
           'dataProvider' => $dataProvider,
           'filterModel' => $searchModel,
           'layerOption' => [
               'update-source' => [
                   'type' => 2,
                   'area' => ['900px','400px'],
                   'shadeClose'=> true,
               ],
               'open' => [
                   'is_confirm' => true,
                   'content' => '你确定要启用吗?',
                   'method' => 'POST',
               ],
           ],
           'columns' => [
               'name',
               [
                   'attribute' => 'source_db_id',
                   'value' => function($dataProvider) use ($sourcedbMap){
                       return isset($sourcedbMap[$dataProvider->source_db_id]) ? $sourcedbMap[$dataProvider->source_db_id] : '未知源';
                   },
                   'filter' => $sourcedbMap,
               ],
               [
                   'attribute' => 'aid_db_id',
                   'value' => function($dataProvider) use ($aiddbMap){
                       return isset($aiddbMap[$dataProvider->aid_db_id]) ? $aiddbMap[$dataProvider->aid_db_id] : '未知源';
                   },
                   'filter' => $aiddbMap
               ],
               'sync_rule',
               'process_num',
               [
                   'attribute' => 'pid',
                   'value' => function($dataProvider){
                       return  $dataProvider->pid == '0' ? '无' : (strlen($dataProvider->pid) > 23 ?  substr($dataProvider->pid,0,23) . '...' : $dataProvider->pid);
                   }
               ],
               [
                   'attribute' => 'status',
                   'contentOptions' => function($dataProvider){
                       return BgTask::$statusColorMap[$dataProvider->status];
                   },
                   'value' => function($dataProvider){
                       return $dataProvider->status == 0 ? '未开始' : ($dataProvider->status == 1 ? '正在执行' : ($dataProvider->status == 2 ? '执行失败' : '执行成功'));
                   }
               ],
               [
                   'attribute' => 'start_timestamp',
                   'value' => function($dataProvider){
                       return $dataProvider->start_timestamp == 0 ? '无' : date('Y-m-d H:i:s',$dataProvider->start_timestamp);
                   }
               ],
               [
                   'attribute' => 'end_timestamp',
                   'value' => function($dataProvider){
                       return  $dataProvider->end_timestamp == 0 ? '无' : date('Y-m-d H:i:s',$dataProvider->end_timestamp);
                   }
               ],
               [
                   'attribute' => 'execute_time',
                   'value' => function($dataProvider){
                       return $dataProvider->execute_time . '秒';
                   }
               ],
               [
                   'attribute' => 'is_open',
                   'contentOptions' => function($dataProvider){
                       $colorMap =  [
                           '0' => ['class' => 'bg-default'],
                           '1' => ['class' => 'bg-success'],
                       ];
                       return $colorMap[$dataProvider->is_open];
                   },
                   'value' => function($dataProvider){
                       return $dataProvider->is_open == 1 ? '是' : '否';
                   },
                   'filter' => [1 => '是',0 => '否'],
               ],

               [
                   'class' => ResponsiveActionColumn::className(),
                   'template' => '{view} {update-source} {update} {open} {delete}',
                   'header' => '操作',
                   'buttons' => [
                       'update-source' => function ($url, $model, $key) {
                           return Html::button('修改数据源', [
                               'url' => $url,
                               'class' => 'btn btn-success btn-sm data-update-source',
                           ]);
                       },
                       'update' => function ($url, $model, $key) {
                           return Html::button('拉取配置', [
                               'url' => $url,
                               'class' => 'btn btn-warning btn-sm data-update',
                           ]);
                       },
                       'open' => function ($url, $model, $key) {
                           return Html::button($model->is_open == 0 ? '启用' : '停用', [
                               'url' => $url,
                               'class' => $model->is_open == 0 ? 'btn btn-success btn-sm data-open' : 'btn btn-default btn-sm data-open',
                           ]);
                       },
                   ],
               ],
           ],
       ]); ?>
   </div>
</div>
