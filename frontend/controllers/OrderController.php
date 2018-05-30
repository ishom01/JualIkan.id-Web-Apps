<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use frontend\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = Date('Y-m-d');
        $query = new Query;
        $query
              ->from('`order` c')
              ->orderBy(['c.order_date' => SORT_ASC]);

        // $query = Fish::find()->limit(10)->orderBy(['fish_id' => SORT_DESC]);
        $count = count($query);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $provider,
        ]);
    }

    public function actionHariini()
    {
        $date = Date('Y-m-d');
        $query = new Query;
        $query
              ->from('`order`')
              ->andFilterWhere(['like', 'order_date',$date])
              ->orderBy(['order_date' => SORT_ASC]);

        // $query = Fish::find()->limit(10)->orderBy(['fish_id' => SORT_DESC]);
        $count = count($query);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('hariini', [
            'searchModel' => $searchModel,
            'dataProvider' => $provider,
            'jumlah' => $count,
        ]);
    }

    public function actionBulanini()
    {
        $month = Date('m');
        $last  = date('t');

        $firstDate = Date('Y-'. $month . '-1');
        $lastDate = Date('Y-'. $month . '-' . $last);

        $query = Order::find()->where(['between', 'order_date', $firstDate, $lastDate]);
        $count = count($query);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $searchModel = new OrderSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bulanini', [
            'searchModel' => $searchModel,
            'dataProvider' => $provider,
        ]);
    }

    /**
     * Displays a single Order model.
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

    public function actionGenerate()
    {
        $model = Order::find()->All();
        return $this->render('generate', [
            'model' => $model,
        ]);
    }

    public function actionGenerate2()
    {
        $model = Order::find()->All();
        return $this->render('generate2', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionVerifikasipembayaran($id){
        $model = $this->findModel($id);
        $model->order_status = 1;
        if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        }else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}