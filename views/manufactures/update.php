<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manufactures */

$this->title = 'Update Manufactures: ' . $model->manufacture_id;
$this->params['breadcrumbs'][] = ['label' => 'Manufactures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->manufacture_id, 'url' => ['view', 'id' => $model->manufacture_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="manufactures-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
