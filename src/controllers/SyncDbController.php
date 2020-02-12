<?php

namespace dsj\sync\web\controllers;

use dsj\sync\web\models\TSyncDb;
use dsj\sync\web\models\TSyncDbSearch;
use Yii;
use dsj\components\controllers\WebController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SyncDbController implements the CRUD actions for TSyncDb model.
 */
class SyncDbController extends WebController
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
     * Lists all TSyncDb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TSyncDbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TSyncDb model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TSyncDb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TSyncDb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirectParent(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TSyncDb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirectParent(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TSyncDb model.
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
     * Finds the TSyncDb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TSyncDb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TSyncDb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTestConnect($id){
        try{
            $model = $this->findModel($id);

            $db = TSyncDb::getActiveDb($model);

            $db->close();

            Yii::$app->session->setFlash('success',$model->name . ':连接成功');

            return $this->redirect(['index']);
        }catch (\Exception $e){
            Yii::$app->session->setFlash('danger',$model->name .':连接失败：' . $e->getMessage());

            return $this->redirect(['index']);
        }
    }
}
