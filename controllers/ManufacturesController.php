<?php

namespace app\controllers;

use app\models\Regions;
use app\models\Towns;
use Yii;
use app\models\Manufactures;
use app\models\ManufacturesSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManufacturesController implements the CRUD actions for Manufactures model.
 */
class ManufacturesController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Manufactures models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufacturesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $regions = ArrayHelper::map(Regions::find()->all(), 'region_id', 'region_name');

        foreach ($regions as $regionID => $regionName) {
            $regionTowns = Towns::find()
                ->asArray()
                ->where(['town_region' => $regionID])
                ->all();

            $regionTowns = array_column($regionTowns, 'town_id');

            $manufacturesCount = Manufactures::find()
                ->where(['in', 'manufacture_town',  $regionTowns])
                ->count();

            $regions[$regionID] = "{$regions[$regionID]} ({$manufacturesCount})";
        }

        $region = null;
        $towns = null;
        $town = null;
        if (!empty(Yii::$app->request->queryParams['manufacture_region'])) {
            $region = Yii::$app->request->queryParams['manufacture_region'];

            $towns = Towns::find()
                ->asArray()
                ->where(['town_region' => Yii::$app->request->queryParams['manufacture_region']])
                ->all();

            $towns = ArrayHelper::map($towns, 'town_id', 'town_name');

            foreach ($towns as $townID => $townName) {
                $manufactureTownCount = Manufactures::find()
                    ->where(['manufacture_town' => $townID])
                    ->count();

                $towns[$townID] = "{$towns[$townID]} ({$manufactureTownCount})";
            }
        }

        if (!empty(Yii::$app->request->queryParams['manufacture_town'])) {
            $town = Yii::$app->request->queryParams['manufacture_town'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'regions' => $regions,
            'region' => $region,
            'towns' => $towns,
            'town' => $town,
        ]);
    }

    /**
     * Displays a single Manufactures model.
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
     * Creates a new Manufactures model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufactures();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->manufacture_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Manufactures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->manufacture_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Manufactures model.
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
     * Finds the Manufactures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manufactures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufactures::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
