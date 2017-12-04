<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Url;
use kartik\widgets\TouchSpin;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kato\pickadate\Pickadate;
/* @var $this yii\web\View */
/* @var $model common\models\TTripSearch */
/* @var $form yii\widgets\ActiveForm */
$blnUrlPlus = date('Y-m',strtotime('+1 MONTH',strtotime($varmonth)));
$blnUrlMin = date('Y-m',strtotime('-1 MONTH',strtotime($varmonth)));
?>
<div class="panel-group material-tabs-group">
    <ul class="nav nav-tabs material-tabs material-tabs_primary">
        <li class="active"><a href="#filter" class="material-tabs__tab-link" data-toggle="tab">Filter</a></li>
        <li><a href="#topup" class="material-tabs__tab-link" data-toggle="tab">Update Data</a></li>
        
    </ul>       
    <div class="tab-content materail-tabs-content">
        <div class="tab-pane fade active in" id="filter">
        <div class="row">
            
             <div class="col-md-2">
            <?= Html::label('Month','', ['class' => 'control-label']); ?>
            <?= Html::dropDownList('bulan',$selected = date('m'), $listBulan,
              [
               'id'=>'form-bulan',
              'class' => 'form-control',
              'prompt'=>'Chose Month To Dislay',

              ]); ?>
            </div>
            <div class="col-md-2">
              <?= Html::label('Year','', ['class' => 'control-label']); ?>
            <?= Html::dropDownList('bulan',null, $listTahun,
              [
              'id'=>'form-tahun',
              'class' => 'form-control',
              ]); ?>
            </div>
            
            <div class="col-md-8">
            <br>
            <?= Html::button('Submit', [
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_lg',
                'onclick'=>'
                var month = $("#form-bulan").val();
                var tahun = $("#form-tahun").val();
                 $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                $.ajax({
                url:"'.Url::to(["index"]).'/"+tahun+month,
                type: "POST",
                    success:function(data){
                      $("#div-schedule").html(data);
                    },
                    error:function(data){
                      $("#div-schedule").html("<center>Something Its Wrong...<br>Try To Reload Page</center>");
                    },
                })',
                ]); ?>
            <?= Html::a('Previous Month',null,[
                'class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg',
                'onclick'=>'
                     $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                    $.ajax({
                    url:"'.Url::to(["/trip/index","month"=>$blnUrlMin]).'",
                    type: "POST",
                    success:function(data){
                      $("#div-schedule").html(data);
                    },
                    error:function(data){
                      $("#div-schedule").html("<center>Something Its Wrong...<br>Try To Reload Page</center>");
                    },
                  })'
            ]) ?>
            <?= Html::a('Next Month',null,[
                'class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg',
                'onclick'=>'
                     $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                     $.ajax({
                    url:"'.Url::to(["/trip/index","month"=>$blnUrlPlus]).'",
                    type: "POST",
                    success:function(data){
                      $("#div-schedule").html(data);
                    },
                    error:function(data){
                      $("#div-schedule").html("<center>Something Its Wrong...<br>Try To Reload Page</center>");
                    },

                  })'
            ]) ?>
            
            </div>
            </div>
        </div>
        <div class="tab-pane fade" id="topup">
        <div class="row">
        <div class="col-md-12">
        <div class="col-md-2">
      <label>Update Stock</label>
        <?= TouchSpin::widget([
              'name' => 'topup-stok',
              'id' =>'form-topup',
              'readonly'=>true,
              'pluginOptions' => [
                'verticalbuttons' => true,
                'initval'         => 1,
                'min'             => 1,
                'max'             => 100,
                'step'            => 1,

                ],
          ]);

        ?>
        </div>
        <div class="col-md-2">
            <label>Change Status</label>
            <?= Html::dropDownList('status', $selection = null, ['1'=>'ON','2'=>'Off'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-status']); ?>
            </div>
        <div class="col-md-12">
         <div class="col-md-9">
        <?= Html::radioList('type-topup', $selection = '1', $items = ['1'=>'Up','2'=>'Down'], ['id' => 'radio-topup-type']); ?>

        </div>
          
        </div>
        <div class="row col-md-12">
         <div class="col-md-2">

        <?= Html::a('Save',null,[
            'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-saved',
            'onclick'=>'
                    var vdtime = $("#table-trip .checkbox-trip:checkbox:checked").attr("dept-time");
                    var vdate = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                        return $(this).attr("date");
                        }).get();
                    var viroute = $("#table-trip .checkbox-trip:checkbox:checked").attr("island-route");

                    var topval = $("#form-topup").val();
                    var toptype = $("#radio-topup-type :radio:checked").val();
                    if (toptype == "" || topval == "" || vdtime == "" || vdate == ""|| viroute == "") {
                      alert("Select Trip and fill topup value First");
                      return false;
                    }else{
                      if(confirm("Confirm \\r\\n Selected Trip will be Topup Stock? ")){
                        $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                        $.ajax({
                            url: "'.Url::to(["update-stock-by-island"]).'",
                            type: "POST",
                            async: true, 
                            data: {dtime: vdtime, date: vdate, iroute: viroute, topup: topval, type: toptype},
                            success: function() {
                                  $.pjax.reload({
                                  timeout:10000,
                                  container:"#pjax-trip",
                                  });
                                  $("#hidden-panel").trigger("click");
                            }, 
                        });
                      }else{
                        return false;
                      }
                    }  
                '
        ]) ?>
       </div>
          <div class="col-md-2">
            <?= Html::a(' Update Status ',null,[
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-saved',
                'onclick'=>'
                        var vdtime = $("#table-trip .checkbox-trip:checkbox:checked").attr("dept-time");
                        var vdate = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                        return $(this).attr("date");
                        }).get();
                        var viroute = $("#table-trip .checkbox-trip:checkbox:checked").attr("island-route");

                        // alert(vdtime);
                        // alert(vdate);
                        // alert(viroute);

                        var stsv = $("#drop-status").val();
                        if (vdtime == "" || stsv == "" || vdate == ""|| viroute == "") {
                          alert("Select Trip and Status First");
                          return false;
                        }else{
                          if(confirm("Confirm \\r\\n Selected Trip will be change status? ")){
                            $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                            $.ajax({
                                url: "'.Url::to(["change-status-by-island"]).'",
                                type: "POST",
                                async: true, 
                                data: {dtime: vdtime, date: vdate, iroute: viroute, sts: stsv},
                                success: function() {
                                      $.pjax.reload({
                                      timeout:10000,
                                      container:"#pjax-trip",
                                      });
                                      $("#hidden-panel").trigger("click");
                                }, 
                            });
                          }else{
                            return false;
                          }
                        } 
                    '
            ]) ?>
        </div>
       
        </div>
      </div>
        </div>
        </div>
            
           


    </div>
</div>
