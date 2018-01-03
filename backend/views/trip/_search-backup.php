<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
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
        <li><a href="#topup" class="material-tabs__tab-link" data-toggle="tab">Stock</a></li>
        <li><a href="#edit" class="material-tabs__tab-link" data-toggle="tab">Edit</a></li>
        <li><a href="#update" class="material-tabs__tab-link" data-toggle="tab">Update</a></li>
        
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
                url:"'.Url::to("/trip/index").'/"+tahun+month,
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
            <?= Html::dropDownList('status', $selection = null, ['1'=>'ON','2'=>'Off','3'=>'Blocked'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-status']); ?>
            </div>
            <div class="col-md-2">
            <label>Adult Prices</label>
            <?= MaskedInput::widget([
            'name' => 'adult_price',
            'id' => 'edit-adult-price',
            'mask' => '999,999',
            ]); ?>
            </div>
            <div class="col-md-2">
              <label>Child Price</label>
               <?= MaskedInput::widget([
            'name' => 'child_price',
            'id' => 'edit-child-price',
            'mask' => '999,999',
            ]); ?>
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
               <div class="col-md-2  col-md-offset-1">
            <?= Html::a(' Submit Price',null,[
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-saved',
                'onclick'=>'
                        var idtrip = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                        return $(this).val();
                        }).get();

                        var adultprice = $("#edit-adult-price").val();
                        var childprice = $("#edit-child-price").val();
                        if (idtrip == "") {
                          alert("Select Trip First");
                          return false;
                        }else{
                          if (adultprice == "" && childprice == "") {
                            alert("Please Insert Adult Or Child Price");
                            return false;
                          }else if(confirm("Confirm \\r\\n Price For Selected Trip will be change To custom? ")){
                            $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                            $.ajax({
                                url: "'.Url::to(["change-price"]).'",
                                type: "POST",
                                async: true, 
                                data: {id: idtrip, adult: adultprice, child: childprice},
                                success: function() {
                                      $.pjax.reload({
                                      timeout:10000,
                                      container:"#pjax-trip",
                                      })
                                }, 
                            });
                            return true;
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
      <div class="tab-pane fade" id="update">
        <div class="row">
          <div class="panel-group material-accordion material-accordion_success" id="accordion2">
      <div class="panel panel-default material-accordion__panel material-accordion__panel">
        <div class="panel-heading material-accordion__heading" id="acc2_headingOne">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion2" href="#acc2_collapseOne" class="material-accordion__title">Search Form Based</a>
          </h4>
        </div>
        <div id="acc2_collapseOne" class="panel-collapse collapse in material-accordion__collapse">
          <div class="panel-body">
            <div class="row">
        <div class="col-md-12">
        </div>
          <div class="col-md-4">
<?php 
    $layout3 = <<< HTML
    {input1}
    {separator}
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i id="remove-date-range" class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

        echo '<center><label class="control-label">Select date range</label></center>';
        echo DatePicker::widget([
            'type'          => DatePicker::TYPE_RANGE,
            'name'          => 'start_date',
            'name2'         => 'end_date',
            'separator'     => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'options'       => ['placeholder' => 'Start date','id'=>'form-start-date'],
            'options2'      => ['placeholder' => 'End date','id'=>'form-end-date'],
            'layout'        => $layout3,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);
        ?>
          </div>
          <div class="col-md-2">
            <?php
            echo '<label class="control-label">Company</label>';
            echo Select2::widget([
            'name' => 'company',
            'data' => $listCompany,
            'id'  =>'form-company',
            'options' => [
            'placeholder' => 'Select Company ...',
            'multiple' => false
            ],
            ]);
            ?>
          </div>
           <div class="col-md-2">
            <?php
            echo '<label class="control-label">Route</label>';
            echo Html::dropDownList('route',$selected = null, $listRoute,
              [
               'id'=>'form-route',
              'class' => 'form-control',
              'prompt'=>'Chose Route ...',

              ]); 
            ?>
          </div>
          <div class="col-md-2">
          <label class="control-label">Dept Time</label>
            <?= Pickadate::widget([
              'isTime' => true,
              'name'=>'dept-time',
              'id'=>'form-dept-time',
              'pickadateOptions' => [
                'format'=> 'H:i',
                'interval'=>15,
              ],
            ]); ?>
          </div>
          <div class="col-md-12">
           <?= Html::button(' Delete', [
                    'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-trash',
                    'onclick'=>'
                        var start = $("#form-start-date").val();
                        var end = $("#form-end-date").val();
                        var company = $("#form-company").val();
                        var route = $("#form-route").val();
                        var dtime = $("#form-dept-time").val();

                        if (start == "" || end == "" || company == "" || route == "" || dtime == "") {
                          alert("Please Fill All Form Data");
                          return false;
                        }else{
                           if(confirm("Confirm \\r\\n Data Will Be deleted And This Cannot Be Undone? ")){
                             $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                               $.ajax({
                                url: "'.Url::to(["multiple-delete"]).'",
                                type: "POST",
                                async: true, 
                                data: {start: start, end: end, company: company, route: route, dtime: dtime},
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
                    ]); ?>
              <?= Html::button(' Update', ['id'=>'btn-modal','class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-upload']); ?>
          </div>
        </div>
          </div>
        </div>
      </div>
      <div class="panel panel-default material-accordion__panel">
        <div class="panel-heading material-accordion__heading">
          <h4 class="panel-title">
            <a class="collapsed material-accordion__title" data-toggle="collapse" data-parent="#accordion2" href="#acc2_collapseTwo">Checkbox Based</a>
          </h4>
        </div>
        <div id="acc2_collapseTwo" class="panel-collapse collapse material-accordion__collapse">
          <div class="panel-body">
            <div class="row">
           <div class="col-md-12">
            <?= Html::a(' Delete ',null,[
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-trash',
                'onclick'=>'
                        var idtrip = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                        return $(this).val();
                        }).get();
                        if (idtrip == "") {
                          alert("Select Trip First");
                          return false;
                        }else{
                          if(confirm("Confirm \\r\\n Selected Trip Will Be deleted And This Cannot Be Undone? ")){
                            $("#judul-table").html("<center><img src=\'/spinner.svg\'></center>");
                            $.ajax({
                                url: "'.Url::to(["delete-checkbox"]).'",
                                type: "POST",
                                async: true, 
                                data: {id: idtrip},
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
            <?= Html::button(' Update', ['id'=>'btn-update-checkbox','class' => 'btn material-btn material-btn_danger main-container__column material-btn_md glyphicon glyphicon-upload']); ?>
        </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
      </div>
    </div>
</div>
<?php
$this->registerJs("
    $('#btn-modal').click(function(){
       $('.checkbox-trip').prop('checked', false);
        var start = $('#form-start-date').val();
        var end = $('#form-end-date').val();
        var company = $('#form-company').val();
        var route = $('#form-route').val();
        var dtime = $('#form-dept-time').val();
      if (start == '' || end == '' || company == '' || route == '' || dtime == '') {
          alert('Please Fill All Form Data');
          return false;
        }else{
          $('#btn-modal-check').hide();
          $('#btn-modal-form').show();
          $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
            });
          
        }
    });
    $('#btn-update-checkbox').click(function(){

        var idtrip = $('#table-trip .checkbox-trip:checkbox:checked').map(function(){
          return $(this).val();
          }).get();
          if (idtrip == '') {
            alert('Select Trip First');
            return false;
          }else{
            $('#btn-modal-check').show();
            $('#btn-modal-form').hide();
          $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
            });
          
        }
    });
        
");
?>
<div class="modal material-modal material-modal_primary fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content material-modal__content">
      <div class="modal-header material-modal__header">
        <button id="btn-close-modal" class="close material-modal__close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title material-modal__title">Update Trip Data</h4>
      </div>
      <div class="modal-body material-modal__body">
        <div class="row">
        <div class="col-md-2">
      <label>Update Stock</label>
        <?= TouchSpin::widget([
              'name' => 'update-stok',
              'id' =>'form-update-stock',
              'pluginOptions' => [
                'verticalbuttons' => true,
                'initval'         => 1,
                'min'             => 0,
                'max'             => 100,
                'step'            => 1,

                ],
          ]);

        ?>
        </div>
        <div class="col-md-2">
        <label>Dept Time</label>
          <?= Pickadate::widget([
              'isTime' => true,
              'name'=>'update-dept-time',
              'id'=>'form-update-dept-time',
              'pickadateOptions' => [
                'format'=> 'H:i',
                'interval'=>15,
              ],
            ]); ?>
        </div>

         <div class="col-md-2">
        <label>Est Time</label>
          <?= Html::dropDownList('update-est-time',null, ['Wait'=>'Please Wait...'],
              [
              'id'=>'form-update-est-time',
              'class' => 'form-control',
              ]); ?>
        </div>
        <div class="col-md-2">
            <label>Change Status</label>
            <?= Html::dropDownList('update-status', $selection = null, ['1'=>'ON','2'=>'Off','3'=>'Blocked'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-update-status']); ?>
        </div>
        <div class="col-md-2">
          <label>Adult Prices</label>
          <?= MaskedInput::widget([
            'name' => 'update-adult_price',
            'id' => 'update-adult-price',
            'mask' => '999,999',
            ]); ?>
            </div>
        <div class="col-md-2">
          <label>Child Price</label>
               <?= MaskedInput::widget([
            'name' => 'update-child_price',
            'id' => 'update-child-price',
            'mask' => '999,999',
            ]); ?>
        </div>
        <div class="col-md-12">
         <div class="col-md-9">
         <label>Up</label>
        <?= Html::checkbox('modal-checkbox-up', $checked = false, [
            'value'=>'1',
            'class' => 'check',
            'id'=>'check-up',
            'onchange'=>'
              if ($(this).is(":checked")) {
                $("#check-down").prop("checked", false);
              }
              ',
            ]); ?>
        <label>Down</label>
        <?= Html::checkbox('modal-checkbox-down', $checked = false, [
            'value'=>'2',
            'class' => 'check',
            'id'=>'check-down',
            'onchange'=>'
              if ($(this).is(":checked")) {
                $("#check-up").prop("checked", false);
              }'
            ]); ?>
        </div>
        </div>
        <div style="display: none;" id="btn-modal-form" class="col-md-12">
          <?= Html::button('Submit Changes', [
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_lg4 glyphicon glyphicon-trash btn-block',
                'onclick'=>'

                        var start = $("#form-start-date").val();
                        var end = $("#form-end-date").val();
                        var company = $("#form-company").val();
                        var route = $("#form-route").val();
                        var dtime = $("#form-dept-time").val();

                        var dept = $("#form-update-dept-time").val();
                        var est = $("#form-update-est-time").val();
                        var stock = $("#form-update-stock").val();
                        var sts = $("#drop-update-status").val();
                        var uadult = $("#update-adult-price").val();
                        var uchild = $("#update-child-price").val();
                        var type = $(".check:checkbox:checked").val();
                       
                           if(confirm("Confirm \\r\\n Data On Filtered Will be Updated? ")){
                            $("#btn-close-modal").hide();
                             $(this).html("<center><img src=\'/spinner.svg\'></center>");
                               $.ajax({
                                url: "'.Url::to(["update-multiple"]).'",
                                type: "POST",
                                async: true, 
                                data: {start: start, end: end, company: company, route: route, dtime: dtime, dept: dept, est: est, stock: stock, sts: sts, type: type, adult: uadult, child: uchild},
                                success: function() {
                                     location.reload();
                                }, 
                              });
                            }else{
                              return false;
                            }
                        
                '
                ]); ?>
        </div>
        <div style="display: none;" id="btn-modal-check" class="col-md-12">
          <?= Html::button('Submit Changes', [
                'class' => 'btn material-btn material-btn_danger main-container__column material-btn_lg4 glyphicon glyphicon-trash btn-block',
                'onclick'=>'
                     var idtrip = $("#table-trip .checkbox-trip:checkbox:checked").map(function(){
                  return $(this).val();
                  }).get();
                    var dept = $("#form-update-dept-time").val();
                    var est = $("#form-update-est-time").val();
                    var stock = $("#form-update-stock").val();
                    var typ = $(".check:checkbox:checked").val();
                    var sts = $("#drop-update-status").val();
                    var uadult = $("#update-adult-price").val();
                    var uchild = $("#update-child-price").val();
                  if (idtrip == "") {
                    alert("Select Trip First");
                    return false;
                  }else{
                    if(confirm("Confirm \\r\\n Checked Data Will be Updated? ")){
                      $("#btn-close-modal").hide();
                      $(this).html("<center><p>Plese Wait...</p><br><img src=\'/spinner.svg\'></center>");
                      $.ajax({
                      url: "'.Url::to(["update-multiple"]).'",
                      type: "POST",
                      async: true, 
                      data: {idtrip: idtrip, dept: dept, est: est, stock: stock, sts: sts, type: typ, adult: uadult, child: uchild},
                      success: function() {
                                location.reload();
                      }, 
                      });
                    }else{
                     return false;
                   }
                  }
                        
                '
                ]); ?>
        </div>
      </div>
      <div class="modal-footer material-modal__footer">
      </div>
    </div>
  </div>
</div>
</div>

<?php

$this->registerJs('
  $("#body-summary").html("<center><div class=\'col-md-12\'><img src=\'/spinner.svg\'></div></center>");
     $.ajax({
      url:"'.Url::to(["list-time"]).'",
      type: "POST",
      success:function(data){
        $("#form-update-est-time").html(data);
      }
    })', \yii\web\View::POS_READY);
?>