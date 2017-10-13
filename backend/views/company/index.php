<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcompany-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-lg btn-danger glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
           // 'address',
            [
            'header'=>'Email Bali',
            'format'=>'email',
            'value'=>'email_bali'],
            [
            'header'=>'Email Bali',
            'format'=>'email',
            'value'=>'email_gili'],
           // 'email_gili:email',
            'phone',
            ['header'=>'POD',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->id_pod == 1) {
                   return "<b class='text-primary'>".$model->idPod->name."</b>";
                }else{
                    return "<b class='text-danger'>".$model->idPod->name."</b>";
                }
             }
            ],
            ['header'=>'Logo',
            'format'=>'raw',
            'value'=>function($model){
                return Html::a(Html::img(['/company/logo','logo'=>$model->logo_path], ['class' => 'img-responsive','style'=>'width:150px;height: 45px']),['/company/view','id'=>$model->id],[
                        'data-toggle'=>"modal",
                        'data-target'=>"#myModal",
                        'data-title'=>"Detail Data",
                        ]); 

            },
            ],
            ['header'=>'User',
           'value'=>'idUser.username'],
            //'create_at',
            //'update_at',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
]);
 
echo '...';
 
Modal::end();
?>
<?php
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>
