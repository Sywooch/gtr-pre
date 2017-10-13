<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TBooking */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_trip',
            'id_payment',
            'email:email',
            'phone',
            'trip_price',
            'total_price',
            'currency',
            'total_idr',
            'exchange',
            'id_status',
            'id_payment_method',
            'send_amount',
            'token:ntext',
            'process_by',
            'expired_time',
            'datetime',
        ],
    ]) ?>

</div>
