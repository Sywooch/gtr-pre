<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Booking Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-index">
<div class="row col-md-12">
    <?php  echo $this->render('_search', [
                'model' => $searchModel,
                'bookingList' => $bookingList,
                'listDept' => $listDept,

                ]); ?>
</div>
<center><b id="loading-pjax"></b></center>
<span class="text-danger pull-right fa fa-warning">* Infant Not Included </span>
<div class="col-md-12">

<?php Pjax::begin(['id'=>'pjax-table-booking']); ?>
<?= GridView::widget([
        'dataProvider'    => $dataProvider,
        'filterModel'     => $searchModel,
        'panel'           => ['type'=>'primary', 'heading'=>'Booking Data'],
        'export'    =>false,
        'striped'         => true,
        'bordered'        => true,
        'hover'           => true,
        'responsive'      => true,
        'responsiveWrap'  => true,
        'showPageSummary' => true,
        'pjax'            => true,
        'pjaxSettings'    => [
            'neverTimeout' =>true,
        ],
        'columns' => [
            [
            'class' => 'kartik\grid\SerialColumn',
            'width'=>'10px',
            ],
        /*[
        'header'=>' ',
        'width'=>'50px',
        'value'=>function($model){
            return " ";
        }
        ],*/
        [
            'header'=>'Route',
            'attribute'=>'id_route',
            'format'=>'raw',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<p class='route'>".$model->idTrip->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idTrip->idRoute->arrivalHarbor->name."</p>";
            },
            'group'=>true,  // enable grouping
            'groupedRow'=>true,
            // 'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
            //     return [
            //         'mergeColumns'=>[[0, 3]], // columns to merge in summary
            //         'content'=>[              // content to show in each summary cell
            //             0=>'Summary By Route(' . $model->idTrip->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idTrip->idRoute->arrivalHarbor->name . ')',
            //             5=>GridView::F_SUM,
                       
            //         ],
            //         'contentFormats'=>[      // content reformatting for each summary cell
            //             5=>['format'=>'number', 'decimals'=>0],
            //         ],
            //         'contentOptions'=>[      // content html attributes for each summary cell
            //             5=>['style'=>'text-align:center'],
            //         ],
            //         // html attributes for group summary row
            //         'options'=>['class'=>'success','style'=>'font-weight:bold; width: 10px;']
            //     ];
            // },
            
        ],
        [
        'header'=>'Dept Time',
        'attribute'=>'idTrip.dept_time',
        'vAlign'=>'middle',
        'width'=>'100px',
        'format'=>'raw',
        'value'=>function($model){
            return "<span class='dept-time'><span class='fa fa-clock-o'> ".date('H:i',strtotime($model->idTrip->dept_time));
        },
        'group'=>true,  // enable grouping
        'groupedRow'=>true,
        'subGroupOf'=>0,
        // 'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
        //         return [
        //             'mergeColumns'=>[[3, 4]], // columns to merge in summary
        //             'content'=>[              // content to show in each summary cell
        //                 3=>'Summary By Dept Time ( '.date("H:i",strtotime($model->idTrip->dept_time)).' )',
        //                 5=>GridView::F_SUM,
                       
        //             ],
        //             'contentFormats'=>[      // content reformatting for each summary cell
        //                 5=>['format'=>'number', 'decimals'=>0],
        //             ],
        //             'contentOptions'=>[      // content html attributes for each summary cell
        //                 5=>['style'=>'text-align:center;'],
        //             ],
        //             // html attributes for group summary row
        //             'options'=>['class'=>'danger','style'=>'font-weight:bold;']
        //         ];
        //     },
        
        ],
        [
        'header'=>'Buyer/Customer',
        'width'=>'auto',
        'format'=>'raw',
        'value'=>function($model){
            if (!empty($model->shuttleTmp->id_booking)) {
                return "<p class='customer'><span class='fa fa-qrcode'></span> ".$model->id."-<span class='fa fa-user'></span> ".$model->idPayment->name." <span class='fa fa-phone'></span> ".$model->idPayment->phone." <span class='fa fa-envelope'></span> ".$model->idPayment->email."
                    <br>".$model->shuttleTmp->type."-<span class='fa fa-map'></span> ".$model->shuttleTmp->idArea->area."-<span class='fa fa-building'></span> ".$model->shuttleTmp->location_name."-<span class='fa fa-map-marker'></span>".$model->shuttleTmp->address."-<span class='fa fa-phone' ></span>".$model->shuttleTmp->phone."</p>";
            }else{
                return "<p class='customer'><span class='fa fa-qrcode'></span> ".$model->id."-<span class='fa fa-user'></span> ".$model->idPayment->name." <span class='fa fa-phone'></span> ".$model->idPayment->phone." <span class='fa fa-envelope'></span> ".$model->idPayment->email;
            }
            
        },
        'pageSummary'=>'Grand Total',
        'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
        'header'=>'<span class="fa fa-calendar"></span> Trip Date',
        'format'=>'raw',
        'hAlign'=>'center',
        'width'=>'125px',
        'value'=>function($model){
            return date('D, d-m-Y',strtotime($model->idTrip->date));
        },
        'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
        'attribute'=>'PAX*',
        'width'=>'50px',
        'hAlign'=>'center',
        'value'=>function($model){
            
            return count($model->affectedPassengers);
        },
        'format'=>['decimal', 0],
        'pageSummary'=>true,
        'pageSummaryOptions'=>['class'=>'grand-total'],
        ],
        [
        'header'=>'Detail',
        'format'=>'raw',
        'width'=>'25px',
        'value'=>function($model){
            return Html::a('', ['detail-modal','id_booking'=>$model->id], [
            'class' => 'btn btn-xs btn-warning glyphicon glyphicon-modal-window',
            'data-toggle'=>"modal",
            'data-target'=>"#detail-modal",
            'data-title'=>"Detail Data",
            ]);
        },
        ],
        [
        'header'=>'Download <br> Ticket',
        'hAlign'=>'center',
        'format'=>'raw',
        'width'=>'25px',
        'value'=>function($model){
            return Html::a('', '/booking/ticket?id_booking='.$model->id, [
            'class' => 'btn btn-xs btn-primary glyphicon glyphicon-download',
            'data-toggle' =>'tooltip',
            'title'       =>'Download Ticket',
            'data' => [
                'method' => 'post',
            ],
            ]);
        },
        ],
        ],
    ]); ?>
    </div>

<?php Pjax::end(); ?>
</div>
<?php

Modal::begin([
    'id'=>'detail-modal',
    'header' => '<h2>Passenger Detail</h2>',
    'size'=>'modal-lg',
]);

echo '...';

Modal::end();

$this->registerJs("
    $('#detail-modal').on('show.bs.modal', function (event) {
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
$customCss = <<< SCRIPT
    .dept-time{
        padding-left: 25px;
    }
    .customer{
        padding-left: 20px;
    }
    .route{
        font-weight: bold;
        font-size: 14px;
    }
    .grand-total{
        font-size: 20px;
        font-weight: bold;
    }
SCRIPT;
$this->registerCss($customCss);
?>