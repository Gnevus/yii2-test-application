<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Manufactures */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manufactures-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manufacture_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'manufacture_town')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
