<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Content';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tcontent-index">
    <p>
        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>

<?php if(Helper::checkRoute('/booking/validation')): ?>
        <?= Html::a(' Type', ['/type-content/index'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-list']) ?>
<?php endif; ?>
    </p>
     <?php  echo $this->render('_search', [
                'model' => $searchModel,
                'modelContent' => $modelContent,
                ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
            'header'=>'title',
            'value'=> 'title',
            ],
            
           
            'slug',
           // 'content:ntext',
            ['header'=>'Author',
            'value'=>'author0.username',],
            
            
             'created_at:datetime',
             'updated_at:datetime',

            
            [
            'header'=>'preview',
            'format'=>'raw',
            'value'=>function($model){
                return Html::a('',['view','id'=>$model->id],[
                        'class'=>'glyphicon glyphicon-eye-open',
                        'data-toggle'=>"modal",
                        'data-target'=>"#modalPreview",
                        'data-title'=>"Content Preview",
                        ]);
            }
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{update} - {delete}'
            ],
        ],
    ]); ?>
</div>
<?php
Modal::begin([
    'id' => 'modalPreview',
    'header' => '<h4 class="modal-title">...</h4>',
    'size'=>'modal-lg',
]);
 
echo '...';
 
Modal::end();
?>
<?php
$this->registerJs("
    $('#modalPreview').on('show.bs.modal', function (event) {
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