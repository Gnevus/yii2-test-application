<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ManufacturesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufactures-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= Html::dropDownList('manufacture_region', $region, $regions, ['onchange'=>'this.form.submit()']); ?>
    <?php if ($towns): ?>
        <?= Html::dropDownList('manufacture_town', $town, $towns, ['onchange'=>'this.form.submit()']); ?>
    <?php endif; ?>

    <?= Html::a('Reset',['index'], ['class' => 'btn btn-outline-secondary btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
