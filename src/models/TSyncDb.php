<?php

namespace dsj\sync\web\models;

use Yii;

/**
 * This is the model class for table "t_sync_db".
 *
 * @property int $id
 * @property int $type 1源数据库2目标数据库
 * @property string $name 连接名
 * @property int $db_type 0mysql
 * @property string $host 主机名
 * @property string $db_name 数据库名
 * @property int $port 端口
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $connect_charset 字符集
 * @property string $failed_num
 */
class TSyncDb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_sync_db';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['port','failed_num'], 'integer'],
            [['type', 'db_type'], 'integer', 'max' => 128],
            [['name'], 'string', 'max' => 32],
            [['host'], 'string', 'max' => 50],
            [['db_name'], 'string', 'max' => 30],
            [['username', 'connect_charset'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 64],
            [['port','type', 'db_type','name','host','db_name','username','password','connect_charset'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'name' => '连接名',
            'db_type' => '连接类型',
            'host' => '主机名',
            'db_name' => '数据库名',
            'port' => '端口',
            'username' => '用户名',
            'password' => '密码',
            'connect_charset' => '字符集',
            'failed_num' => '失败次数'
        ];
    }

    public static function getDbMap($condition = []){
        return self::find()->select('name,id')
            ->where($condition)
            ->indexBy('id')
            ->column();
    }

    public static function getAllTables($id){
        $model = self::findOne(['id' => $id]);

        $db = self::getActiveDb($model);

        $tables = $db->createCommand("show tables")->queryAll();

        return array_column($tables,'Tables_in_' . $model->db_name,'Tables_in_' . $model->db_name);
    }

    /**
     * @param $model self
     * @return \yii\db\Connection
     * @throws \yii\db\Exception
     */
    public static function getActiveDb($model){

        $connection = new \yii\db\Connection([
            'dsn' => "mysql:host={$model->host};dbname={$model->db_name};port={$model->port}",
            'username' => "{$model->username}",
            'password' => "{$model->password}",
            'charset' => "{$model->connect_charset}",
        ]);

        $connection->open();

        return $connection;
    }

    public static function getActiveDbById($id){

        $model = self::findOne(['id' => $id]);

        return self::getActiveDb($model);
    }
}
