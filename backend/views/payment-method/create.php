<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TPaymentMethod */

$this->title = 'Create Tpayment Method';
$this->params['breadcrumbs'][] = ['label' => 'Tpayment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpayment-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
