<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TPrivateOperatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tprivate Operators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-operator-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Operator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'phone',
            'email:email',
            [
            'header'=>'Status',
            'format'=>'raw',
            'value'=>function($model){
                $class = $model->id_status == 1 ? 'text-success' : 'text-danger';
                return '<b class="'.$class.'">'.$model->idStatus->status.'</b>';
            }
            ],
            // 'datetime',

            [
            'class' => 'yii\grid\ActionColumn',
            'template' =>'{update} - {delete}'
            ],
        ],
    ]); ?>
</div>
