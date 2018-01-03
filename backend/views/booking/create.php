<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TBooking */

$this->title = Yii::t('app', 'Create Tbooking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
