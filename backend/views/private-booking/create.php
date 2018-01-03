<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TPrivateBooking */

$this->title = 'Create Tprivate Booking';
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-booking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
