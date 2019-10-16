<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ManufacturesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manufactures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufactures-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Manufactures', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Перейти на страницу товаров', ['/products/'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  echo $this->render('_search', ['model' => $searchModel, 'regions' => $regions, 'region' => $region, 'towns' => $towns, 'town' => $town]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'manufacture_id',
            'manufacture_name:ntext',
            'manufacture_town',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
