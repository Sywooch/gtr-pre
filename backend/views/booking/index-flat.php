<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use mdm\admin\components\Helper;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TBookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Booking Data';
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
<div class="col-md-12">
    <?php  echo $this->render('_search', [
                'model' => $searchModel,
                'bookingList' => $bookingList,
                'listDept' => $listDept,
                'listCompany' => $listCompany,
                'listBuyer'      => $listBuyer,

                ]); ?>
    

</div>

<center><b id="loading-pjax"></b></center>
<span class="text-danger pull-right fa fa-warning">* Infant Not Included </span>
<div class="col-md-12">

<?php Pjax::begin(['id'=>'pjax-table-booking']); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'=>['type'=>'primary', 'heading'=>'Booking Data'],
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

                    $logStatus = Yii::$app->runAction('/booking/check-log',['id_payment'=>$model->id_payment]);

                return "<span class=\"fa fa-user\"></span> ".$model->idPayment->name." <span class=\"fa fa-phone\"></span> ".$model->idPayment->phone." <span class=\"fa fa-envelope\"></span> ".$model->idPayment->email." <span class=\"fa fa-money\"></span> ".$model->idPayment->idPaymentMethod->method." <span class=\"fa fa-clock-o\"> </span> ".date('d-m-Y H:i',strtotime('-2 HOURS',strtotime($model->idPayment->exp)))." <span>".$logStatus."</span>
                    <span class='dropdown material-dropdown btn btn-xs'>".
                    Html::button('<span class=\'fa fa-envelope\'></span> <span class=\'caret\'></span>', ['type' => 'button','class'=>'btn btn-xs btn-danger dropdown-toggle','data-toggle'=>'dropdown','aria-expanded'=>false,'aria-haspopup'=>true]).
                    "<ul class='dropdown-menu material-dropdown-menu_danger'>
                        <li class='dropdown-header material-dropdown__header'>Resend</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li>".Html::a('Fastboat Reservation','#loading-pjax', [
                                'id-payment' => $model->id_payment,
                                'type'       => 1,
                                'class'      => 'btn-resend-reservation-payment material-dropdown-menu__link'])."</li>
                        <li>".Html::a('Customer Ticket', '#loading-pjax', [
                                'id-payment' =>$model->id_payment,
                                'class'      => 'btn-resend-customer-payment material-dropdown-menu__link'])."</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li class='dropdown-header material-dropdown__header'>Cancellation</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li>".Html::a('Fastboat Cancellation','#loading-pjax', [
                                'id-payment' => $model->id_payment,
                                'type'       => 2,
                                'class'      => 'btn-resend-reservation-payment material-dropdown-menu__link'])."</li>   
                                              
                    </ul>
                    </span>"; 
                    
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
                    $shuttle = !empty($model->shuttleTmp->id_booking) ? "<br> Required ".$model->shuttleTmp->type." in ".$model->shuttleTmp->idArea->area."-".$model->shuttleTmp->location_name."-".$model->shuttleTmp->address."-".$model->shuttleTmp->phone : " ";
                    $dropdown =  "<span class='dropdown material-dropdown btn btn-xs'>".
                    Html::button('<span class=\'fa fa-envelope\'></span> <span class=\'caret\'></span>', ['type' => 'button','class'=>'btn btn-xs btn-info dropdown-toggle','data-toggle'=>'dropdown','aria-expanded'=>false,'aria-haspopup'=>true]).
                    "<ul class='dropdown-menu material-dropdown-menu_primary'>
                        <li class='dropdown-header material-dropdown__header'>Resend</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li>".Html::a('Fastboat Reservation','#loading-pjax', [
                                'id-booking' => $model->id,
                                'type'       => 1,
                                'class'      => 'btn-resend-reservation-booking material-dropdown-menu__link'])."</li>
                        <li>".Html::a('Customer Ticket', '#loading-pjax', [
                                'id-booking' =>$model->id,
                                'class'      => 'btn-resend-customer-booking material-dropdown-menu__link'])."</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li class='dropdown-header material-dropdown__header'>Cancellation</li>
                        <li class='divider material-dropdown__divider'></li>
                        <li>".Html::a('Fastboat Cancellation','#loading-pjax', [
                                'id-booking' => $model->id,
                                'type'       => 2,
                                'class'      => 'btn-resend-reservation-booking material-dropdown-menu__link'])."</li>   
                                              
                    </ul>
                    </span>";
                    $modify = Html::button('', [
                                'id-booking'  => $model->id,
                                'class'       => 'btn-modify btn btn-xs btn-warning glyphicon glyphicon-calendar',
                                'data-toggle' => "tooltip",
                                'data-title'  => "Modify This Booking",
                                ]);
                    $logger = Yii::$app->runAction('/booking/check-log-booking',['id_booking'=>$model->id]);
                    return "<a data-toggle='popover' data-trigger='hover focus' data-popover-content='#".$model->id."',data-placement='bottom' class='fa fa-question-circle'></a> <b>".$model->idTrip->idBoat->idCompany->name."</b>( <span class='text-primary'>".$model->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$model->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($model->idTrip->date))."</b> At <b>". date('H:i',strtotime($model->idTrip->dept_time))."</b> ".$dropdown.$modify." <span>".$logger."</span> ".$shuttle.$popover;
                
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
            [
            'header'=>'Detail',
            'format'=>'raw',
            'value'=>function($model){
                return  Html::a('', ['detail-modal','id_booking'=>$model->id], [
            'class' => 'btn btn-xs btn-warning glyphicon glyphicon-modal-window',
            'data-toggle'=>"modal",
            'data-target'=>"#booking-modal",
            'data-title'=>"Detail Data",
            ]);
            }
            ],
        ],
        'options' => [
            'style' => 'overflow: auto; word-wrap: break-word;'
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

Modal::begin([
    'id'=>'booking-modal',
    'header' => '<h2>Booking Detail</h2>',
    'size'=>'modal-lg',
    
]);

echo '...';

Modal::end();

Modal::begin([
    'id'       => 'booking-modify-modal',
    'header'   => '<h2>Modify This Booking</h2>',
    'size'     => 'modal-lg',
    // 'closeButton'=>false,
    'clientOptions'  =>[
        'backdrop' => 'static',
        'keyboard' => false
        ]
]);

echo '...';

Modal::end();
?>
<?php
$this->registerJs("
 $('#booking-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('data-title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<center><i class=\"fa fa-spinner fa-spin\"></i></center>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        });
$('.btn-modify').on('click',function(){
    $('#booking-modify-modal').modal('show');
    $('#booking-modify-modal').find('.modal-body').html('<center><i class=\"fa fa-spinner fa-spin\"></i></center>');
    var vidb = $(this).attr('id-booking');
    $.ajax({
        url: '".Url::to(["booking-modify"])."',
        type:'POST',
        data:{id_booking :vidb},
        success: function (data) {
            $('#booking-modify-modal').find('.modal-body').html(data);
        }
    });
});
$('#booking-modify-modal').on('hidden.bs.modal', function (event) {
    window.location.href = '".Url::to(["index"])."';
});
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
$('.read-btn').on('click',function(){
    var vidp = $(this).attr('value');
    krajeeDialog.confirm(\"Confirm This Booking Is Read And Check By Yourself?\", function (result) {
        if (result) {
            $.ajax({
                url: '".Url::to(["read-check-payment"])."',
                type:'POST',
                data:{idp :vidp},
                success: function (data) {
                     location.reload();
                }
            });
        } else {
           
        }
    });
});
$('.btn-resend-customer-payment').on('click',function(){
    var idp = $(this).attr('id-payment');
    krajeeDialog.confirm(\"<div class='col-md-12'>Are you sure you want to Resend Ticket To Customer?</div><div class='col-md-12'><div class='main-container__column material-checkbox-group material-checkbox-group_warning'><input value='1' type='checkbox' id='checkbox-receipt-payment' name='checkbox_receipt_payment' class='material-checkbox'><label class='material-checkbox-group__label' for='checkbox-receipt-payment'>Include Receipt ?</label></div></div>\", function (result) {
        if (result) {
            $('#modal-loading').modal({
              backdrop: 'static',
              keyboard: false
            });
            var vpreceipt = $('#checkbox-receipt-payment:checkbox:checked').val();
            $.ajax({
                url: '".Url::to(["resend-ticket-payment"])."',
                type:'POST',
                data:{id_payment :idp, receipt: vpreceipt},
                success: function (data) {
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                },
                error:function(data){
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                }
            });
        } else {
           
        }
    });
    
   
});

$('.btn-resend-customer-booking').on('click',function(){
    var idb = $(this).attr('id-booking');
    krajeeDialog.confirm(\"<div class='col-md-12'>Are you sure you want to Resend Ticket To Customer?</div><div class='col-md-12'><div class='main-container__column material-checkbox-group material-checkbox-group_warning'><input value='1' type='checkbox' id='checkbox-receipt' name='checkbox' class='material-checkbox'><label class='material-checkbox-group__label' for='checkbox-receipt'>Include Receipt ?</label></div></div>\", function (result) {
        if (result) {
            var vreceipt = $('#checkbox-receipt:checkbox:checked').val();
            $('#modal-loading').modal({
              backdrop: 'static',
              keyboard: false
            });
            $.ajax({
                url: '".Url::to(["resend-ticket-booking"])."',
                type:'POST',
                data:{id_booking :idb, receipt: vreceipt},
                success: function (data) {
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                },
                error:function(data){
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                }
            });
        } else {
           
        }
    });
    
   
});

function Dialog(data){
    krajeeDialog.alert(data);
}

$('.btn-resend-reservation-payment').on('click',function(){
    var payid = $(this).attr('id-payment');
    var vtype = $(this).attr('type');
        if (vtype == '1' ) {
            var msg = 'Resend Reservation';
        } else if (vtype == '2') {
            var msg = 'Send Cancellation';
        }
    krajeeDialog.confirm(\"Are you sure you want to \"+msg+\" To Fastboat?\", function (result) {
        if (result) {
            
            $('#modal-loading').modal({
                      backdrop: 'static',
                      keyboard: false
                  });
            $.ajax({
                url: '".Url::to(["resend-reservation-payment"])."',
                type:'POST',
                data:{id_payment :payid, type: vtype},
                success: function (data) {
                     $('#modal-loading').modal('hide');
                    Dialog(data);
                },
                error:function(data){
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                }
            });
        }else{
            
        }
    });
});

$('.btn-resend-reservation-booking').on('click',function(){
    var vbookid = $(this).attr('id-booking');
    var vtypebook = $(this).attr('type');
        if (vtypebook == '1' ) {
            var msg = 'Resend Reservation';
        } else if (vtypebook == '2') {
            var msg = 'Send Cancellation';
        }
    krajeeDialog.confirm(\"Are you sure you want to \"+msg+\" To Fastboat?\", function (result) {
        if (result) {
            $('#modal-loading').modal({
                      backdrop: 'static',
                      keyboard: false
                  });
            $.ajax({
                url: '".Url::to(["resend-reservation-booking"])."',
                type:'POST',
                data:{id_booking :vbookid, type: vtypebook},
                success: function (data) {
                     $('#modal-loading').modal('hide');
                    Dialog(data);
                },
                error:function(data){
                    $('#modal-loading').modal('hide');
                    Dialog(data);
                }
            });
        }else{
            
        }
    });
});

    
    "); 
 ?>

<div class="modal material-modal material-modal_primary fade" id="modal-loading">
  <div class="modal-dialog modal-sm">
    <div class="modal-content material-modal__content">
      <div class="modal-header material-modal__header">
        <h4 class="modal-title material-modal__title">Process Your Request...</h4>
      </div>
      <div class="modal-body material-modal__body">
        <div id="detail" class="row col-md-12">
        <p>Please Wait....!!!<br>Please Don't Reload Page before Complete
        <center><i class="fa fa-spinner fa-spin"></i></center>
        </p>
      </div>
      <div class="modal-footer material-modal__footer">
      </div>
    </div>
  </div>

</div>
</div>
