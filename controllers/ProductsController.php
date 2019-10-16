<?php

namespace app\controllers;

use app\models\Categories;
use app\models\ProductCategories;
use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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

    public function actionGenerateDBData()
    {
        //таким способом заполнил БД,
        // мог конечно через миграции, но выбрал самый быстрый и интересный способ для меня.
        ini_set('memory_limit', '350M');
        //заполняем таблицу городов.
        $shetchik = 0;
        $region = 1;
        for ($i = 1; $i <= 600; $i++) {
            $shetchik++;
            if ($shetchik < 12) {
                $town = new Towns();
                $town->town_name = "Город №{$i}";
                $town->town_region = $region;
                $town->save();
            } else {
                $shetchik = 0;
                $town = new Towns();
                $town->town_name = "Город №{$i}";
                $town->town_region = $region;
                $town->save();
                $region++;
            }
        }

        //заполняем таблицу регионов
        for ($i = 1; $i <= 50; $i++) {
            $region = new Regions();
            $region->region_name = "Регион №{$i}";
            $region->save();
        }

        //заполняем таблицу производителей
        $shetchik = 0;
        for ($i = 1; $i <= 10000; $i++) {
            $shetchik++;
            if ($shetchik <= 600) {
                $manufacture = new Manufactures();
                $manufacture->manufacture_name = "Производитель №{$i}";
                $manufacture->manufacture_town = $shetchik;
                $manufacture->save();
            } else {
                $shetchik = 1;
                $manufacture = new Manufactures();
                $manufacture->manufacture_name = "Производитель №{$i}";
                $manufacture->manufacture_town = $shetchik;
                $manufacture->save();
            }
        }

        //заполняем таблицу товаров
        $products = [];
        $shetchik = 0;
        $timestamp = strtotime("2010-01-01");
        for ($i = 1; $i <= 150; $i++) {
            for ($v = 1; $v <= 1000; $v++) {
                $productNumber = $i * $v;
                $shetchik++;

                if ($shetchik <= 10000) {
                    $products[] = ["Товар №{$productNumber}", $shetchik, $timestamp];
                } else {
                    $shetchik = 1;
                    $products[] = ["Товар №{$productNumber}", $shetchik, $timestamp];
                }

                $randomDays = rand(1, 2920);
                $timestamp = strtotime("2010-01-01 +{$randomDays} days");
            }

            Yii::$app->db->createCommand()->batchInsert('products', ['product_name', 'product_manufacture', 'product_date'], $products)->execute();
            $products = [];
        }

        //заполняем таблицу категорий
        $categories = [];
        for ($i = 1; $i <= 10; $i++) {
            $categories[] = ["Категория №{$i}", 0];
        }

        $shetchik = 0;
        for ($i = 1; $i <= 10; $i++) {
            for ($v = 1; $v <= 10; $v++) {
                $shetchik++;
                $categories[] = ["Подкатегория №{$shetchik}", $i];
            }
        }
        Yii::$app->db->createCommand()->batchInsert('categories', ['category_name', 'category_parent'], $categories)->execute();


        //заполняем таблицу линков товар-категория
        $productCategoryLink = [];
        $shetchik = 1;
        for ($i = 1; $i <= 150000; $i++) {
            if ($shetchik <= 110) {
                $productCategoryLink[] = [$i, $shetchik];
            } else {
                $shetchik = 1;
                $productCategoryLink[] = [$i, $shetchik];
            }
            $shetchik++;
        }
        Yii::$app->db->createCommand()->batchInsert('product_categories', ['pc_product_id', 'pc_category_id'], $productCategoryLink)->execute();


        die(var_dump('Done!'));
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $categories = ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');

        foreach ($categories as $categoryID => $categoryName) {
            $categoryProductCount = ProductCategories::find()
                ->where(['pc_category_id' => $categoryID])
                ->count();

            $categories[$categoryID] = "{$categories[$categoryID]} ({$categoryProductCount})";
        }

        $productCategory = null;
        if (!empty(Yii::$app->request->queryParams['product_category'])) {
            $productCategory = Yii::$app->request->queryParams['product_category'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'productCategory' => $productCategory,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
