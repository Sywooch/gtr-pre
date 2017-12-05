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
<center><b id="loading-pjax"></b></center>
<span class="text-danger pull-right fa fa-warning">* Infant Not Included </span>
<div class="col-md-12">

<?php Pjax::begin(['id'=>'pjax-table-booking']); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>'Validation Data'],
        'striped'      =>true,
        'bordered'  => true,
        'hover'        =>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute'=>'id_payment',
                'width'=>'auto',
                'format'=>'raw',
                'contentOptions'=>['style'=>'font-size:15px;'],
                'value'=>function ($model, $key, $index, $widget) {
                
                return "<span class=\"fa fa-user\"></span> ".$model->idPayment->name." <span class=\"fa fa-phone\"></span> ".$model->idPayment->phone." <span class=\"fa fa-envelope\"></span> ".$model->idPayment->email." <span class=\"fa fa-money\"></span> ".$model->idPayment->idPaymentMethod->method." <span class=\"fa fa-clock-o\"> </span> ".date('d-m-Y H:i',strtotime($model->idPayment->update_at));
                },
                
                'group'             =>true,  // enable grouping,
                'groupedRow'        =>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class
                'groupFooter'       =>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns'=>[[0,2]], // columns to merge in summary
                        'content'=>[             // content to show in each summary cell
                           // 0=> $model->idPayment->name." - ".$model->idPayment->phone,
                           // 4=>GridView::F_AVG,
                           // 5=>GridView::F_SUM,
                           // 6=>GridView::F_SUM,
                        ],
                        'contentFormats'=>[      // content reformatting for each summary cell
                          //  4=>['format'=>'number', 'decimals'=>2],
                           // 5=>['format'=>'number', 'decimals'=>0],
                           // 6=>['format'=>'number', 'decimals'=>2],
                        ],
                        'contentOptions'=>[      // content html attributes for each summary cell
                           // 0=>['style'=>'font-variant:small-caps'],
                           // 4=>['style'=>'text-align:right'],
                            //5=>['style'=>'text-align:right'],
                            //6=>['style'=>'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'success','style'=>'font-weight:bold;']
                    ];
            }
            ],
            [
            'header'=>'Code',
            'value'=>'id',
            'contentOptions'=>['style'=>'font-size:14px; font-weight:bold;'],
            'width'=>'50px',
            ],
            [
                'header'=>'Trip Description',
                'format'=>'raw',
                'contentOptions'=>['style'=>'font-size:14px;'],
                'value'=>function($model){
                    $popover = "<div id='".$model->id."' class='hidden panel panel-primary'>
                                    <div class='col-lg-12 popover-heading panel bg-primary'>
                                     <center>Fastboat Contact</center>
                                    </div>
                                    <div class='popover-body list-group col-lg-12' >
                                        <div class='col-sm-3' style='font-weight:bold;'><span class='fa fa-phone'></span></div><div class='col-sm-9'>".$model->idTrip->idBoat->idCompany->phone."</div>
                                        <div class='col-sm-3' style='font-weight:bold;'><span class='fa fa-envelope'></span></div><div class='col-sm-9'>".$model->idTrip->idBoat->idCompany->email_bali."<br>".$model->idTrip->idBoat->idCompany->email_gili."</div>
                                    </div>
                                </div>
                                ";
                    if (!empty($model->shuttleTmp->id_booking)) {
                        return "<a data-toggle='popover' data-trigger='hover focus' data-popover-content='#".$model->id."' data-placement='bottom' class='fa fa-question-circle'></a> <b>".$model->idTrip->idBoat->idCompany->name."</b> ( <span class='text-primary'>".$model->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$model->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($model->idTrip->date))."</b> At <b>". date('H:i',strtotime($model->idTrip->dept_time))."</b><br> Required ".$model->shuttleTmp->type." in ".$model->shuttleTmp->idArea->area."-".$model->shuttleTmp->location_name."-".$model->shuttleTmp->address."-".$model->shuttleTmp->phone.$popover;
                    }else{
                    return "<a data-toggle='popover' data-trigger='hover focus' data-popover-content='#".$model->id."',data-placement='bottom' class='fa fa-question-circle'></a> <b>".$model->idTrip->idBoat->idCompany->name."</b>( <span class='text-primary'>".$model->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$model->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($model->idTrip->date))."</b> At <b>". date('H:i',strtotime($model->idTrip->dept_time))."</b><br>".$popover;
                }
                }
            ],
            [
                'header'=>'Passengers*',
                'format'=>'raw',
                'hAlign'=>'center',
                'contentOptions'=>['style'=>'font-size:14px;'],
                'value'=>function($model){
                  
                    $Child = count($model->childPassengers);
                    $Infant = count($model->infantPassengers);
                    $Adult = count($model->adultPassengers);
                    $PAxTotal = count($model->affectedPassengers);
                    if ($Child == null && $Infant == null) {
                       return "<b>".$PAxTotal." Pax </b><br>".$Adult." Adult";
                    }elseif ($Child == null && $Infant != null) {
                       return "<b>".$PAxTotal." Pax </b><br>".$Adult." Adult, ".$Infant." Infant";
                    }elseif($Child != null && $Infant == null){
                        return "<b>".$PAxTotal." Pax </b><br>".$Adult." Adult, ". $Child." Child";
                    }else{
                        return "<b>".$PAxTotal." Pax </b><br>".$Adult." Adult, ". $Child." Child, ".$Infant." Infant";
                    }
                    
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
</div>
<?php 
$customCss = <<< SCRIPT
    .grand-total{
        font-size: 20px;
        font-weight: bold;
    }
SCRIPT;
$this->registerCss($customCss);
?>
<?php
$this->registerJs("

$(function(){
    $('[data-toggle=popover]').popover({
        html : true,
        content: function() {
          var content = $(this).attr('data-popover-content');
          return $(content).children('.popover-body').html();
        },
        container:'.table',
        title: function() {
          var title = $(this).attr('data-popover-content');
          return $(title).children('.popover-heading').html();
        }
    });
  });
    ");
 ?>