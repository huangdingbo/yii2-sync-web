<?php

use yii\helpers\Json;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\sync\models\TSyncTask */

$this->title = '查看:' . $model->name;
?>
<div class="tsync-task-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'source_db_id',
                'value' => function($model) use ($sourcedbMap){
                    return isset($sourcedbMap[$model->source_db_id]) ? $sourcedbMap[$model->source_db_id] : '未知源';
                },
            ],
            [
                'attribute' => 'aid_db_id',
                'value' => function($model) use ($aiddbMap){
                    return isset($aiddbMap[$model->aid_db_id]) ? $aiddbMap[$model->aid_db_id] : '未知源';
                },
            ],
            'pid',
            'process_num',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status == 0 ? '未开始' : ($model->status == 1 ? '正在执行' : ($model->status == 2 ? '执行失败' : '执行成功'));
                }
            ],
            'sync_rule',
            [
                    'attribute' => 'execute_rule',
                    'value' => function($model){
                        return $model->execute_rule == '0' ? new ArrayObject() : $model->execute_rule;
                    }
            ],
            [
                'attribute' => 'sync_tables',
                'value' => function($model){
                    $arr = \yii\helpers\Json::decode($model->sync_tables);
                    return implode(',',$arr);
                }
            ],
            [
                'attribute' => 'start_timestamp',
                'value' => function($model){
                    return $model->start_timestamp == 0 ? '无' : date('Y-m-d H:i:s',$model->start_timestamp);
                }
            ],
            [
                'attribute' => 'end_timestamp',
                'value' => function($model){
                    return  $model->end_timestamp == 0 ? '无' : date('Y-m-d H:i:s',$model->end_timestamp);
                }
            ],
            [
                'attribute' => 'execute_time',
                'value' => function($model){
                    return $model->execute_time . '秒';
                }
            ],
            [
                'attribute' => 'is_open',
                'value' => function($model){
                    return $model->is_open == 1 ? '是' : '否';
                },
            ],
            [
                'attribute' => 'extra',
                'value' => function($model){
                    return $model->extra == '0' ? '无' : $model->extra;
                },
            ],
        ],
    ]) ?>

</div>



