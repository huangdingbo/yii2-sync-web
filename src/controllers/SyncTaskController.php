<?php

namespace dsj\sync\web\controllers;

use dsj\sync\web\models\TSyncDb;
use dsj\sync\web\models\TSyncTask;
use dsj\sync\web\models\TSyncTaskSearch;
use Yii;
use dsj\components\controllers\WebController;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SyncTaskController implements the CRUD actions for TSyncTask model.
 */
class SyncTaskController extends WebController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TSyncTask models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TSyncTaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sourcedbMap = TSyncDb::getDbMap(['type' => 1]);
        $aiddbMap = TSyncDb::getDbMap(['type' => 2]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sourcedbMap' => $sourcedbMap,
            'aiddbMap' => $aiddbMap,
        ]);
    }

    /**
     * Displays a single TSyncTask model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $sourcedbMap = TSyncDb::getDbMap(['type' => 1]);
        $aiddbMap = TSyncDb::getDbMap(['type' => 2]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'sourcedbMap' => $sourcedbMap,
            'aiddbMap' => $aiddbMap,
        ]);
    }

    /**
     * Creates a new TSyncTask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TSyncTask();

        if ($model->load(Yii::$app->request->post())) {
            $model->sync_rule = $model->sync_tables =  '0';
            $model->process_num = 0;
            if ($model->save()){
                $this->redirectParent(['index']);
            }
        }

        $sourcedbMap = TSyncDb::getDbMap(['type' => 1]);

        $aiddbMap = TSyncDb::getDbMap(['type' => 2]);
        if ($model->hasErrors()){
            var_dump($model->getErrors());exit;
        }
        return $this->render('create', [
            'model' => $model,
            'sourcedbMap' => $sourcedbMap,
            'aiddbMap' => $aiddbMap,
        ]);
    }

    public function actionUpdateSource($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirectParent(['index']);
        }

        $sourcedbMap = TSyncDb::getDbMap(['type' => 1]);

        $aiddbMap = TSyncDb::getDbMap(['type' => 2]);

        return $this->render('create', [
            'model' => $model,
            'sourcedbMap' => $sourcedbMap,
            'aiddbMap' => $aiddbMap,
        ]);
    }

    /**
     * Updates an existing TSyncTask model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())){
                $model->sync_tables = Json::encode($model->sync_tables);
                $model->execute_rule = $model->execute_rule ? $model->execute_rule : Json::encode(new \ArrayObject());
                if ($model->save()){
                    $this->redirectParent(['index']);
                }else{
                    Yii::$app->session->setFlash('danger',$model->getFirstErrors());
                }
            }
        }
        try{
            $tables = TSyncDb::getAllTables($model->source_db_id);
        }catch (\Exception $e){
            Yii::$app->session->setFlash('danger',$model->name .':连接失败：' . $e->getMessage());

            $this->redirectParent(['index']);
        }

        $model->sync_rule = $model->sync_rule == '0' ? '' : $model->sync_rule;
        $model->execute_rule = $model->execute_rule == '0' ? '' : $model->execute_rule;
        $model->sync_tables = Json::decode($model->sync_tables);
        $model->process_num = $model->process_num == 0 ? 10 : $model->process_num;

        return $this->render('update', [
            'model' => $model,
            'tables' => $tables
        ]);
    }

    public function actionOpen($id){

        $model = $this->findModel($id);

        $model->is_open = $model->is_open == 0 ? 1 : 0;

        $model->start_timestamp = $model->end_timestamp = $model->status = $model->execute_time = 0;

        $model->pid = '0';

        $model->process_num = 10;

        $model->save();

        return $this->redirect(['index']);
    }
    /**
     * Deletes an existing TSyncTask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TSyncTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TSyncTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TSyncTask::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
