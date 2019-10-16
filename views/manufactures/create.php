<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Manufactures */

$this->title = 'Create Manufactures';
$this->params['breadcrumbs'][] = ['label' => 'Manufactures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manufactures-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
