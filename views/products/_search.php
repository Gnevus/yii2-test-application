<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= Html::dropDownList('product_category', $productCategory, $categories, ['onchange'=>'this.form.submit()']); ?>

    <?= Html::a('Reset',['index'], ['class' => 'btn btn-outline-secondary btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
