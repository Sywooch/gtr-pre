<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TKursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tkurs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkurs-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'currency',
            [
            'header'=>'Kurs IDR',
            'value'=>function($model){
                return "Rp ".number_format($model->kurs,0);
            }
            ],
            [
            'header'=>'Last Update',
            'value'=>function($model){
                return date('d-m-Y H:i:s',strtotime($model->update_at));
            }
            ],
        ],
    ]); ?>
</div>
