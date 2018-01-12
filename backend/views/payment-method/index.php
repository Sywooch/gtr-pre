<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TPaymentMethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tpayment Methods';
$this->params['breadcrumbs'][] = $this->title;
echo Dialog::widget([
'dialogDefaults'=>[
    Dialog::DIALOG_CONFIRM => [
        'type'           => Dialog::TYPE_DANGER,
        'title'          => 'Confirm',
        'btnOKClass'     => 'btn-danger',
        'btnOKLabel'     =>' Yes',
        'btnCancelLabel' =>' No'
        ]
    ]]);
?>
<div class="tpayment-method-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(' ', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus-sign']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'method',
            [
                'header'=>'Status',
                'format' => 'raw',
                'value'=>function($model){
                    if ($model->id_status == 1) {
                        return Html::beginForm(['/payment-method/update', 'id' => 'form-payment-'.$model->id], 'post').
                        '<div class="main-container__column materail-switch materail-switch_warning">
                        '.Html::checkbox('TPaymentMethod[id_status]', $checked = true, [
                            'class' => 'materail-switch__element',
                            'id' => 'switch-'.$model->id,
                            'onchange' => '
                                $.ajax({
                                    url: "'.Url::to(['update-ajax']).'",
                                    method:"POST",
                                    data: {id: '.$model->id.', id_status: 2},
                                    success : function(data){
                                        location.reload();
                                    },

                                })'
                        ]).'
                        <label class="materail-switch__label" for="switch-'.$model->id.'"></label>
                        </div> <b class="text-success">ON</b>'.Html::endForm();
                    }elseif ($model->id_status == 2) {
                         return Html::beginForm(['/payment-method/update', 'id' => 'form-payment-'.$model->id], 'post').
                        '<div class="main-container__column materail-switch materail-switch_warning">
                        '.Html::checkbox('TPaymentMethod[id_status]', $checked = false, [
                            'class' => 'materail-switch__element',
                            'id' => 'switch-'.$model->id,
                            'onchange' => '
                                $.ajax({
                                    url: "'.Url::to(['update-ajax']).'",
                                    method:"POST",
                                    data: {id: '.$model->id.', id_status: 1},
                                    success : function(data){
                                        location.reload();
                                    },

                                })'
                        ]).'
                        <label class="materail-switch__label" for="switch-'.$model->id.'"></label>
                        </div> <b class="text-danger">OFF</b>'.Html::endForm();
                    }
                    
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
</div>
