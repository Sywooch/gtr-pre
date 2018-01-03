<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\TCompany;
use common\models\TShuttleArea;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TShuttleTimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tshuttle Times');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-time-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>['type'=>'info', 'heading'=>''],
        'export'=>false,
        'striped'      =>true,
        'bordered'  => true,
        'responsive'=>true,
        'hover'        =>true,
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
           // 'beforeGrid'=>'My fancy content before.',
            //'afterGrid'=>'My fancy content after.',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
           // 'header'=>'Company',
            'attribute'=>'id_company',
            'format'=>'raw',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<span class='fa fa-ship company'>".$model->idCompany->name."</span>";
            },
            'format'=>'raw',
            'group'             =>true,  // enable grouping,
            'groupedRow'        =>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class
            ],
            [
            'header'=>'Company',
            'attribute'=>'id_company',
            'value'=>function($model){
              return " ";
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TCompany::find()->select('id,name')->asArray()->all(), 'id', 'name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Any Company...'],
           // 'width'=>'200px',
            ],
            [
            'header'=>'Departure',
            'attribute'=>'id_route',
            'format'=>'raw' ,
           // 'width'=>'100px',
            'vAlign'=>'top',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<span class='route'>".$model->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idRoute->arrivalHarbor->name."</span>";
            },
            'group'=>true,  // enable grouping
            'groupedRow'        =>true,
            'subGroupOf'=>1, // supplier column index is the parent group,
            ],
            [
            'header'=>'<span class="fa fa-code-fork"> Route</span>',
            'format'=>'raw',
            'attribute'=>'id_route',
            'value'=>function($model){
                return $model->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idRoute->arrivalHarbor->name." / <span class='fa fa-clock-o'> </span> ".$model->dept_time;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Yii::$app->runAction('/trip/get-route'), 'id', 'route','island'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Any Route...'],
            ],
            [
            'header'=>'<span class="fa fa-map-marker"> Area</span>',
            'format'=>'raw',
            'value'=>function($model){
                return $model->idArea->area;
            },
            'attribute'=>'id_area',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TShuttleArea::find()->asArray()->all(), 'id', 'area'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'All Area...'],
            ],
            [
            'header'=>'<span class="fa fa-clock-o"> Time</span>',
            'format'=>'raw',
            'value'=>function($model){
                return $model->shuttle_time_start."<span class='fa fa-arrow-right'>".$model->shuttle_time_end;
            },
            
            ],

            ['class' => 'kartik\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php 
$customCss = <<< SCRIPT
    .route{
        font-size: 15px;
        font-weight: bold;
        padding-left:25px;
    }
    .company{
        font-size: 17px;
        font-weight: bold;
    }
SCRIPT;
$this->registerCss($customCss);
?>