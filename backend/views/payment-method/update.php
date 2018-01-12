<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TPaymentMethod */

$this->title = 'Update Tpayment Method: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tpayment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tpayment-method-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
