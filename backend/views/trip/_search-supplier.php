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
        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>

<div class="panel-group material-tabs-group">
    <ul class="nav nav-tabs material-tabs material-tabs_primary">
        <li class="active"><a href="#filter" class="material-tabs__tab-link" data-toggle="tab">Filter</a></li>
        <li><a href="#topup" class="material-tabs__tab-link" data-toggle="tab">Stock</a></li>
        <li><a href="#edit" class="material-tabs__tab-link" data-toggle="tab">Update</a></li>
        
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
                $.pjax.reload({
                url:"'.Url::to("/trip/index").'/"+tahun+month,
                timeout:10000,
                container:"#pjax-trip",
                })',
                ]); ?>
            <?= Html::a('Previous Month',null,[
                'class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg',
                'onclick'=>'
                     $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                    $.pjax.reload({
                    url:"'.Url::to(["/trip/index","month"=>$blnUrlMin]).'",
                    timeout:10000,
                    container:"#pjax-trip",
                  })'
            ]) ?>
            <?= Html::a('Next Month',null,[
                'class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg',
                'onclick'=>'
                     $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                    $.pjax.reload({
                    url:"'.Url::to(["/trip/index","month"=>$blnUrlPlus]).'",
                    timeout:10000,
                    container:"#pjax-trip",

                  })'
            ]) ?>
            
            </div>
            </div>
        </div>
        <div class="tab-pane fade" id="topup">
        <div class="row">
        <div class="col-md-3">
      <div class="col-md-12">
      <label>Update Stock</label>
        <?= TouchSpin::widget([
              'name' => 'topup-stok',
              'id' =>'form-topup',
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
        <div class="col-md-12">
         <div class="col-md-9">
        <?= Html::radioList('type-topup', $selection = '1', $items = ['1'=>'Up','2'=>'Down'], ['id' => 'radio-topup-type']); ?>

        </div>
         <div class="col-md-2">

        <?= Html::a('Submit Status',null,[
            'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-saved',
            'onclick'=>'
                    var idtrip = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                    return $(this).val();
                    }).get();
                    var topval = $("#form-topup").val();
                    var toptype = $("#radio-topup-type :radio:checked").val();
                    if (idtrip == "" || topval == "") {
                      alert("Select Trip and fill topup value First");
                      return false;
                    }else{
                      if(confirm("Confirm \\r\\n Selected Trip will be Topup Stock? ")){
                        $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                        $.ajax({
                            url: "'.Url::to(["topup"]).'",
                            type: "POST",
                            async: true, 
                            data: {id: idtrip, topup: topval, type: toptype},
                            success: function() {
                                  $.pjax.reload({
                                  timeout:10000,
                                  container:"#pjax-trip",
                                  })
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
        <div class="tab-pane fade" id="edit">
        <div class="row">
            <div class="col-md-2">
            <label>Change Status</label>
            <?= Html::dropDownList('status', $selection = null, ['1'=>'ON','2'=>'Off'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-status']); ?>
            </div>
           <div class="row col-md-12">
          <div class="col-md-2">
            <?= Html::a(' Submit ',null,[
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-saved',
                'onclick'=>'
                        var idtrip = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                        return $(this).val();
                        }).get();

                        var stsv = $("#drop-status").val();
                        var stst = $("#drop-status").text();
                        if (idtrip == "" || stsv == "") {
                          alert("Select Trip and Status First");
                          return false;
                        }else{
                          if(confirm("Confirm \\r\\n Selected Trip will be change status? ")){
                            $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                            $.ajax({
                                url: "'.Url::to(["change-status"]).'",
                                type: "POST",
                                async: true, 
                                data: {id: idtrip, sts: stsv},
                                success: function() {
                                      $.pjax.reload({
                                      timeout:10000,
                                      container:"#pjax-trip",
                                      })
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
