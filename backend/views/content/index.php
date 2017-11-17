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
        <?= Html::a(' Fastboat', ['create-fastboat'], ['class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>

<?php if(Helper::checkRoute('/*')): ?>
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
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute'=>'id_type_content',
                'width'=>'auto',
                'value'=>function ($model, $key, $index, $widget) { 
                        return $model->idTypeContent->type;
                
                },
                'format'=>'raw',
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class
            ],
            [
            'header'=>'title',
            'value'=> 'title',
            ],
            'slug',
            //'created_at:datetime',
           // 'updated_at:datetime',
            ['header'=>'Author',
            'value'=>'author0.username'
            ],
            [
            'header'=>'Up',
            'format'=>'raw',
            'value'=>function($model){
                    return "<center>".Html::a('', ['follow-up', 'id' => $model->id], [
                    'class' => 'glyphicon glyphicon-arrow-up',
                    'data' => [
                    'confirm' => 'Are you sure you want to follow up this content?',
                    'method' => 'post',
                    ],
                    ])."</center>";
                }
            ],
            [
            'header'=>'preview',
            'width'=>'20px',
            'format'=>'raw',
            'value'=>function($model){
                return "<center>".Html::a('',['view','id'=>$model->id],[
                        'class'=>'glyphicon glyphicon-eye-open',
                        'data-toggle'=>"modal",
                        'data-target'=>"#modalPreview",
                        'data-title'=>"Content Preview",
                        ])."</center>";
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