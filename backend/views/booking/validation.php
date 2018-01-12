<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use mdm\admin\components\Helper;
use yii\helpers\Url;
use kartik\dialog\Dialog;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Booking Validation';
$this->params['breadcrumbs'][] = $this->title;
echo Dialog::widget([
'dialogDefaults'=>[
    Dialog::DIALOG_ALERT => [
        'type'        => Dialog::TYPE_PRIMARY,
        'title'       => 'Info',
        'buttonClass' => 'btn-primary btn-dialog',
        'buttonLabel' => 'Ok'
    ],
    Dialog::DIALOG_CONFIRM => [
        'type'           => Dialog::TYPE_PRIMARY,
        'title'          => 'Confirm',
        'btnOKClass'     => 'btn-primary',
        'btnOKLabel'     =>' Ok',
        'btnCancelLabel' =>' Cancel'
        ]
    ]]);
?>

<div class="tbooking-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
<?php  if(Helper::checkRoute('/*')): ?>
    <p>
        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>
    </p>
<?php endif; ?>
<?php Pjax::begin(['id'=>'pjax-validate']); ?>
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
                'value'=>function ($model, $key, $index, $widget) {
                
                $confirmdata = isset($model->idPayment->confirmPayment) ? "<br><span class='fa fa-user'></span> ".$model->idPayment->confirmPayment->name." <span class='fa fa-money'></span> Rp ".number_format($model->idPayment->confirmPayment->amount,0)."<span class='fa fa-book'></span> ".$model->idPayment->confirmPayment->note : " ";


                return "<span class=\"fa fa-user\"></span> ".$model->idPayment->name." <span class=\"fa fa-phone\"></span> ".$model->idPayment->phone." <span class=\"fa fa-envelope\"></span> ".$model->idPayment->email." <span class=\"fa fa-money\"></span> ".$model->idPayment->idPaymentMethod->method." <span class=\"fa fa-clock-o\"> </span> ".date('d-m-Y H:i',strtotime($model->datetime)).$confirmdata.
                "<span class='pull-right'>".
                    Html::button(' ', [
                        'class' => 'btn-detail btn material-btn material-btn_warning main-container__column material-btn_sm glyphicon glyphicon-modal-window',
                        'data-toggle' => 'tooltip',
                        'title' => 'Show Detail',
                      ]).
                    Html::a('', '#', [
                                    'class'       => 'btn material-btn material-btn_primary main-container__column material-btn_sm glyphicon glyphicon-check',
                                    'data-toggle' =>'tooltip',
                                    'title'       =>'Accept All',
                                    'onclick'     =>'
                                        if(confirm("Confirm This Booking Is Valid and Ticket will be Send To Customer")){
                                           $.ajax({
                                               url:"'.Url::to(["validation-accept"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id_payment.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    ]).
                    Html::a('', '#', [
                                    'class'       => 'btn material-btn material-btn_danger main-container__column       material-btn_sm glyphicon glyphicon-remove',
                                    'data-toggle' =>'tooltip',
                                    'title'       =>'Reject All',
                                    'onclick'     =>'
                                        if(confirm("Confirm Alert\\r\\nThis Booking Is Invalid And Rejected?")){
                                           $.ajax({
                                               url:"'.Url::to(["validation-reject"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id_payment.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    
                        ]).
                    "</span>";
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
            'width'=>'50px',
            ],
            [
                'header'=>'Trip Description',
                'format'=>'raw',
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
                'header'=>'Passenger',
                'format'=>'raw',
                'hAlign'=>'center',
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
            /*[
            'header'=>'Confirm',
            'format'=>'raw',
            'hAlign'=>'center',
            'value'=>function($model){
                return "<span class='pull-right'>".
                    Html::a('', '#', [
                                    'class' => 'btn material-btn material-btn_info main-container__column material-btn_xs glyphicon glyphicon-check',
                                    'data-toggle' =>'tooltip',
                                    'title'       =>'Accept This',
                                    'onclick'=>'
                                        if(confirm("Confirm This Booking Is Valid and Ticket will be Send To Customer")){
                                           $.ajax({
                                               url:"'.Url::to(["booking-validate-accept"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    ]).
                    Html::a('', '#', [
                                    'class' => 'btn material-btn material-btn_warning main-container__column       material-btn_xs glyphicon glyphicon-remove',
                                    'data-toggle' =>'tooltip',
                                    'title'       =>'Reject This',
                                    'onclick'=>'
                                        if(confirm("Confirm Alert\\r\\nThis Booking Is Invalid And Rejected?")){
                                           $.ajax({
                                               url:"'.Url::to(["booking-validate-reject"]).'",
                                               type: "POST",
                                               data:{id: '.$model->id.'},
                                               success:function(){
                                                $.pjax.reload({
                                                    container: "#pjax-validate"
                                                })
                                               }
                                           })
                                        }else{
                                            return false;
                                        }
                                    ',
                                    
                        ]).
                    "</span>";
            }
            ],*/

           
            // 'token:ntext',
            // 'process_by',
            // 'expired_time',
            // 'datetime',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
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
$('.btn-detail').on('click',function(){
   $('#modal-detail').modal('show');
});
    ");
 ?>

 <!-- MOdal -->
 <div class="modal material-modal material-modal_primary fade" id="modal-detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content material-modal__content">
      <div class="modal-header material-modal__header">
        <h4 class="modal-title material-modal__title">Detail Data</h4>
      </div>
      <div class="modal-body material-modal__body">
        <div id="detail" class="row col-md-12">
        <center>
          <h4>Please Wait...</h4><br>
          <i class="fa fa-spinner fa-spin"></i>
        </center>
      </div>
      <div class="modal-footer material-modal__footer">
      </div>
    </div>
  </div>

</div>
</div>