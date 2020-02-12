<?php

namespace dsj\sync\web\models;

use Yii;

/**
 * This is the model class for table "t_sync_task".
 *
 * @property int $id
 * @property int $source_db_id 源数据库id
 * @property int $aid_db_id 目标数据库id
 * @property int $pid 进程id号
 * @property string $sync_rule 同步规则
 * @property string $sync_tables 同步的数据表
 * @property int $start_timestamp 开始时间
 * @property int $end_timestamp 结束时间
 * @property int $execute_time 执行时间
 * @property int $is_open 是否启用
 * @property string $extra 执行的额外信息
 * @property int $status 1正在执行2执行失败3执行成功
 * @property string $execute_rule 执行规则
 * @property string $name 任务名称
 */
class TSyncTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sync_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','source_db_id','aid_db_id','sync_rule','sync_tables','process_num'],'required'],
            [['source_db_id', 'aid_db_id', 'start_timestamp', 'end_timestamp', 'execute_time'], 'integer'],
            [['sync_rule','name'], 'string', 'max' => 32],
            [['sync_tables'], 'safe'],
            [['is_open', 'status','process_num'], 'integer', 'max' => 128],
            [['extra','pid'], 'string', 'max' => 100],
            [['execute_rule'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '任务名称',
            'process_num' => '进程数',
            'source_db_id' => '源数据库',
            'aid_db_id' => '目标数据库',
            'pid' => '进程id号',
            'sync_rule' => '同步规则',
            'sync_tables' => '同步数据表',
            'start_timestamp' => '开始时间',
            'end_timestamp' => '结束时间',
            'execute_time' => '执行时间',
            'is_open' => '是否启用',
            'extra' => '执行的额外信息',
            'status' => '状态',
            'execute_rule' => '执行规则',
        ];
    }
}
