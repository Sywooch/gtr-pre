<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use common\models\TCompany;
use common\models\TTrip;
use common\models\TRoute;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TTripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Trip List');
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Html::a('', ['create'], ['class' => 'btn btn-lg btn-danger fa fa-plus-square','data-toggle'=>'tooltip','title'=>'Add Trip']) ?>
<?= Html::button('', ['id'=>'btn-clone-trip','class' => 'btn btn-lg btn-primary fa fa-clone','data-toggle'=>'tooltip','title'=>'Copy Trip']) ?>

 <b style="font-size: 25px;"><center>Trip Summary</center></b>
 <div class="panel-group material-accordion material-accordion_primary" id="grid-summary">
  <div class="panel panel-default material-accordion__panel material-accordion__panel">
        <div class="panel-heading material-accordion__heading" id="acc2_headingOne">
         <h4 class="panel-title">
            <a id="hidden-panel" data-toggle="collapse" data-parent="#grid-summary" href="#summary-grid" class="material-accordion__title">Trip Schedule Summary ( - klik To Display/Hidden - )</a>
         </h4>
        </div>
        <div id="summary-grid" class="panel-collapse collapse in material-accordion__collapse">
          <div class="panel-body">
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'        => ['type'=>'info', 'heading'=>''],
        'striped'      => true,
        'bordered'     => true,
        'responsive'   => true,
        'hover'        => true,
        'pjax'         => false,
        
        'columns' => [
            [
              'class' => 'yii\grid\SerialColumn',

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
            ],
             [
                'attribute'=>'idBoat.idCompany.name',
                'width'=>'auto',
                'value'=>function ($model, $key, $index, $widget) { 
                      return $model->idBoat->idCompany->name;
                },
                'format'=>'raw',
                
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class

            ],
            
            [
            'header'=>'Route',
            'attribute'=>'id_route',
            'value'=>function($model){
              return $model->idRoute->departureHarbor->name." -> ".$model->idRoute->arrivalHarbor->name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Yii::$app->runAction('/trip/get-route'), 'id', 'route','island'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Any Route...'],
            ],
            [
            'header'=>'Time',
            'value'=>function($model){
              return $model->dept_time;
            },
            'attribute'=>'dept_time',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TTrip::find()->select('concat(dept_time) as dept_time')->asArray()->orderBy(['dept_time'=>SORT_ASC])->all(), 'dept_time', 'dept_time'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Anytime...'],
            ],
            [
            'header'=>'start',
            'value'=>function($model){
              return date('d-m-Y',strtotime($model->minDate));
            }
            ],
            [
            'header'=>'End',
            'value'=>function($model){
              return date('d-m-Y',strtotime($model->maxDate));
            }
            ],
            [
            'header'=>'View',
            'format'=>'raw',
            'value'=>function($model){
              return Html::a('', $url = null, [
                      'cid'=>$model->idBoat->id_company,
                      'route'=>$model->id_route,
                      'time' => $model->dept_time,
                      'class' =>'btn-view-schedule btn btn-xs btn-warning glyphicon glyphicon-calendar',
                      'data-toggle'=>'tooltip',
                      'title'=>'View Schedule',
                      'data-placement'=>'left',
                      ]);
            }
            ]

        ],
    ]); ?>

</div>
</div>
</div>
</div>
<div class="row">
<?php Pjax::begin(['id'=>'pjax-trip','class'=>'col-lg-12']); ?>
<div id="div-schedule" class="col-md-12">
  <b><center>Select Summary To View Schedule</center></b>
</div>
<?php Pjax::end(); ?>
</div>

<?php
$this->registerJs('
$(".btn-view-schedule").on("click",function(){

  var idc  = $(this).attr("cid");
  var idr  = $(this).attr("route");
  var time = $(this).attr("time");
  var cb   = "btn btn-xs btn-warning glyphicon glyphicon-calendar";
  var cl   = "fa fa-spinner fa-spin";
  $(this).removeClass(cb);
  $(this).addClass(cl);

  $("#div-schedule").html("<center>Please Wait...<br><img src=\'/spinner.svg\'></center>");
    $.ajax({
      url:"'.Url::to(["index"]).'",
      type: "POST",
      data:{
          company:idc,
          route: idr,
          time: time,
        },
      success:function(data){
        $("#div-schedule").html(data);
        $("#hidden-panel").trigger("click");
        $(".btn-view-schedule").removeClass(cl);
        $(".btn-view-schedule").addClass(cb);
      },
      error:function(data){
        $("#div-schedule").html("<center>Something Its Wrong...<br>Please Try Again</center>");
        $(".btn-view-schedule").removeClass(cl);
        $(".btn-view-schedule").addClass(cb);
      },
    });

});
  ');
 ?>