<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TPaypalTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paypal Transaction Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpaypal-transaction-index">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
            'header'=>'Payer',
            'format'=>'raw',
            'value'=>function($model){
                return $model->idPayer->full_name;
            }
            ],
            [
            'header'=>'Amount',
            'format'=>'raw',
            'hAlign'=>'center',
            'value'=>function($model){
                return $model->amount." ".$model->currency."<br>Rp ".number_format($model->paymentToken->total_payment_idr,0);
            }
            ],
            'idStatus.status',
            //'paypal_time',
            'datetime',

           
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
