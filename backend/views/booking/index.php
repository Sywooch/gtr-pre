<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\Url;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Booking Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-index">
<div class="col-md-12">
    <?php  echo $this->render('_search', [
                'model' => $searchModel,
                'bookingList' => $bookingList,
                'listDept' => $listDept,
                'listCompany' => $listCompany,

                ]); ?>
    

</div>
<span class="text-danger pull-right fa fa-warning">* Infant Not Included </span>
<div class="col-md-12">

<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider'    => $dataProvider,
        'filterModel'     => $searchModel,
        'panel'           => ['type'=>'primary', 'heading'=>'Booking Data'],
        'striped'         => true,
        'bordered'        => true,
        'hover'           => true,
        'showPageSummary' => true,
        'responsive'      => true,
        'responsiveWrap'  => true,
        'pjax'            => true,
        'pjaxSettings'    =>[
            'neverTimeout' =>true,
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
            'attribute'=>'idTrip.idBoat.id_company', 
            'width'=>'50px',
            'format'=>'raw',
            'value'=>function ($model, $key, $index, $widget) {
            $mail_gili = $model->idTrip->idBoat->idCompany->email_gili;
            if ($mail_gili == " " || $mail_gili == "" || $mail_gili == null) {
                 $email = "Bali: ".$model->idTrip->idBoat->idCompany->email_bali;
             }else{
                $email = "Bali: ".$model->idTrip->idBoat->idCompany->email_bali." - Email Gili: ".$model->idTrip->idBoat->idCompany->email_gili;
             }
                return "<span class=\"fa fa-ship\"></span> ".$model->idTrip->idBoat->idCompany->name." <span class=\"fa fa-phone\"></span> ".$model->idTrip->idBoat->idCompany->phone." <span class=\"fa fa-envelope\"></span> ".$email;
            },
            //'filterType'=>GridView::FILTER_SELECT2,
            //'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
            /*'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],*/
            //'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping,
            'groupedRow'=>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[0,3]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        0=>'Summary By Company (' . $model->idTrip->idBoat->idCompany->name . ')',
                       // 4=>GridView::F_AVG,
                        5=>GridView::F_SUM,
                        6=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                        //4=>['format'=>'number', 'decimals'=>2],
                        5=>['format'=>'number', 'decimals'=>0],
                        6=>['format'=>'number', 'decimals'=>0],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        0=>['style'=>'font-size:15px; font-variant:small-caps'],
                       // 4=>['style'=>'text-align:right'],
                        5=>['style'=>'text-align:center'],
                        6=>['style'=>'text-align:center'],
                    ],
                    // html attributes for group summary row
                    'options'=>['class'=>'info','style'=>'font-weight:bold;']
                ];
            },
            'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
            'attribute'=>'idTrip.id_route', 
            'width'=>'100px',
            'vAlign'=>'top',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->idTrip->idRoute->departureHarbor->name." -> ".$model->idTrip->idRoute->arrivalHarbor->name;
            },
            /*'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category'],*/
            'group'=>true,  // enable grouping
            'subGroupOf'=>1, // supplier column index is the parent group,
            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[2, 3]], // columns to merge in summary
                    'content'=>[              // content to show in each summary cell
                        2=>'Summary By Route(' . $model->idTrip->idRoute->departureHarbor->name." -> ".$model->idTrip->idRoute->arrivalHarbor->name . ')',
                       // 4=>GridView::F_AVG,
                        5=>GridView::F_SUM,
                        6=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                       // 4=>['format'=>'number', 'decimals'=>2],
                        5=>['format'=>'number', 'decimals'=>0],
                        6=>['format'=>'number', 'decimals'=>0],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                       // 4=>['style'=>'text-align:right'],
                        5=>['style'=>'text-align:center'],
                        6=>['style'=>'text-align:center'],
                    ],
                    // html attributes for group summary row
                    'options'=>['class'=>'success','style'=>'font-weight:bold;']
                ];
            },
            'pageSummary'=>'Grand Total',
            'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
            'attribute'=>'idTrip.dept_time',
            'group'=>true,
           
        ],
        [
        'class'=>'kartik\grid\ExpandRowColumn',
        'width'=>'50px',
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
            },
        'detailUrl'=>'detail',
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'expandOneOnly'=>true,
        'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
            'header'=>'Jumlah Booking',
            'width'=>'100px',
            'hAlign'=>'center',
            'value'=>function($model){
                $varParam = ['id_company'=>$model->idTrip->idBoat->id_company,'id_route'=>$model->idTrip->id_route,'dept_time'=>$model->idTrip->dept_time,'date'=>$model->idTrip->date];
                $hasil = Yii::$app->runAction('/booking/count-booking',['var'=>$varParam]);
                return $hasil;
            },
            'format'=>['decimal', 0],
            'pageSummary'=>true,
            'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
            'attribute'=>'PAX*',
            'width'=>'50px',
            'hAlign'=>'center',
            'value'=>function($model){
                $varParam = ['id_company'=>$model->idTrip->idBoat->id_company,'id_route'=>$model->idTrip->id_route,'dept_time'=>$model->idTrip->dept_time,'date'=>$model->idTrip->date];
                $Npax = Yii::$app->runAction('/booking/count-passenger',['var'=>$varParam]);
                return $Npax;
            },
            'format'=>['decimal', 0],
            'pageSummary'=>true,
            'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        /*[
            'attribute'=>'Child',
            'width'=>'50px',
            'hAlign'=>'center',
            'value'=>function($model){

            },
        ],
        [
            'attribute'=>'Infant',
            'width'=>'50px',
            'hAlign'=>'center',
            'value'=>function($model){

            },
        ],*/

        ],
    ]); ?>
    </div>
<!--<div class="col-md-12">
<div class=" col-md-8 panel panel-default material-panel material-panel_warning">
            <h5 class="panel-heading material-panel__heading">Summary Passengers</h5>
            <div id="body-summary" class="panel-body material-panel__body">
                Something Its Wrong..Try To reload page or contact Us
                

</div>
</div>
</div>-->
<?php Pjax::end(); ?>
</div>
<?php 
$customCss = <<< SCRIPT
    .grand-total{
        font-size: 20px;
        font-weight: bold;
    }
SCRIPT;
$this->registerCss($customCss);
/*foreach ($dataProvider as $key => $value) {
    var_dump($value);
}
//echo var_dump($dataProvider);
$this->registerJs('
    $("#body-summary").html("<center><div class=\'col-md-12\'><img src=\'/spinner.svg\'></div></center>");
     $.ajax({
                url:"'.Url::to(["summary"]).'",
                type: "POST",
                success:function(data){
                    $("#body-summary").html(data);
                }
              })
    ');*/
?>