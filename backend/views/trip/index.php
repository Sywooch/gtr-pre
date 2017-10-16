<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use mdm\admin\components\Helper;
use kartik\widgets\TouchSpin;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TTripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Trip List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttrip-index col-md-12">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(['id'=>'pjax-trip','class'=>'col-lg-12']); ?>

<?php  
$varmonth = $monthYear;
$month= date('m',strtotime($monthYear));
$year=date('Y',strtotime($monthYear));
$day=date("d");
$endDate=date("t",mktime(0,0,0,$month,$day,$year));
$blnUrlPlus = date('Y-m',strtotime('+1 MONTH',strtotime($varmonth)));
$blnUrlMin = date('Y-m',strtotime('-1 MONTH',strtotime($varmonth)));
?>
  <div class="col-md-12">
  <div class="col-md-12">
  <div class="col-md-12">
        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>
  </div>
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
            'class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg',
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
      <div class="col-md-12">
      <div class="col-md-2">
      <div class="col-md-12">
      <label>Change Status</label>
      <?php if(Helper::checkRoute('/booking/validation')): ?>
        <?= Html::dropDownList('status', $selection = null, ['1'=>'ON','2'=>'Off','3'=>'Blocked'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-status']); ?>
      <?php else: ?>
        <?= Html::dropDownList('status', $selection = null, ['1'=>'ON','2'=>'Off'], ['prompt'=>'Select Status','class' => 'form-control','id'=>'drop-status']); ?>
      <?php endif; ?>
      </div>
      <div class="col-md-12">
        <?= Html::a('Save ',null,[
            'class' => 'btn material-btn material-btn_danger main-container__column material-btn_sm glyphicon glyphicon-saved',
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

        <?= Html::a('Update',null,[
            'class' => 'btn material-btn material-btn_danger main-container__column material-btn_sm glyphicon glyphicon-saved',
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
<?php 
echo "<div class='col-md-12' id='judul-table'><h2 align='center'>".Html::encode(date('F',strtotime($monthYear)))." ".Html::encode(date('Y',strtotime($monthYear)))."</h2>";
echo '<span class="pull-left"><div class="main-container__column material-checkbox-group material-checkbox-group_primary">
                          '.Html::checkbox('checkbox-all-trip', $checked = false, [
                            'id' => 'checkbox-table',
                            'class'=>'material-checkbox',
                            'onchange'=>'
                            if ($(this).is(":checked")) {
                                $(".checkbox-trip").prop("checked", true);
                            }else{
                                $(".checkbox-trip").prop("checked", false);
                            }
                              ',
                            ]).'<label class="material-checkbox-group__label" for="checkbox-table">Select All</label>
                          </div></span></div>';

echo '<table id="table-trip" align="center" class="table table-striped table-responsive">
<thead>
  <tr class="info">
  <td align=center><font color=red>Minggu</font></td>
  <td align=center>Senin</td>
  <td align=center>Selasa</td>
  <td align=center>Rabu</td>
  <td align=center>Kamis</td>
  <td align=center>Jumat</td>
  <td align=center>Sabtu</td>
  </tr>
</thead>
  <tbody>';
//cek tanggal 1 hari sekarang
$s=date ("w", mktime (0,0,0,$month,1,$year));
for ($ds=1;$ds<=$s;$ds++) {
echo "<td style=\"font-family:arial;color:#B3D9FF\" align=center valign=middle >
</td>";
}
for ($d=1;$d<=$endDate;$d++) {
    //jika variabel w= 0 disini 0 adalah hari minggu akan membuat baris baru dengan </tr>
    if (date("w",mktime (0,0,0,$month,$d,$year)) == 0) {
        echo "<tr class='baris'>"; 
    }
   // $fontColor="#000000";
    //menentukan warna pada tanggal hari biasa
    if (date("d",mktime (0,0,0,$month,$d,$year)) == "Sun") {  }
      $today = date("Y-m-d",mktime (0,0,0,$month,$d,$year));

      if(Helper::checkRoute('/*')){
           $trips = $model2->where('id_boat IS NOT :nuel',['nuel'=>null])->andWhere(['date'=>$today])->orderBy(['dept_time'=>SORT_ASC])->all();
        }else{
            $trips = $model2->where('t_company.id_user = :userid',[':userid'=>Yii::$app->user->identity->id])->andWhere(['date'=>$today])->orderBy(['dept_time'=>SORT_ASC])->all();
        }

      
    //tanggal
    echo "<td style=\"font-family:arial;color:#333333\" align=center valign=middle> <span><li style='list-style: none; background-color: #ccc;'>".date("d",mktime (0,0,0,$month,$d,$year));

     
    //trip list
    echo Html::checkbox('checkbox-multi-'.$today, $checked = false, [
          'class' => 'pull-right',
          'onchange'=>'
            if ($(this).is(":checked")) {
                $(".checkbox-'.$today.'").prop("checked", true);
            }else{
                $(".checkbox-'.$today.'").prop("checked", false);
            }
              ',
            
          ])." ";
    echo Html::a('', ['add-dayli','date'=>$today], ['class' => ' text-danger btn btn-xs glyphicon glyphicon-plus pull-left'])."</li><br><br>"; 
    
    if (!empty($trips)) {
        foreach ($trips as $key => $value) {
          if ($value->id_season == null) {
            echo Html::a(date('H:i',strtotime($value->dept_time))." ".substr($value->idBoat->idCompany->name, 0,5)."... (".$value->stock.")", '#detail', ['class' =>'pull-left text-warning append text-info tip','data-toggle'=>'popover', 'data-trigger'=>'hover focus', 'data-popover-content'=>'#'.$value->id,'data-placement'=>'bottom']);
          }else{
            if ($value->status == 1) {
              $warna_text = "pull-left text-success append text-info tip";
            }elseif ($value->status == 2) {
              $warna_text = "pull-left text-danger append text-info tip";
            }else{
              $warna_text = "pull-left bg-danger text-danger append text-info tip";
            }
            echo Html::a(date('H:i',strtotime($value->dept_time))." ".substr($value->idBoat->idCompany->name, 0,5)."... (".$value->stock.")",
           '#detail', ['class' => $warna_text,'data-toggle'=>'popover', 'data-trigger'=>'hover focus', 'data-popover-content'=>'#'.$value->id,'data-placement'=>'bottom']);

          }
        //checkbox per trip
        echo Html::checkbox('checkbox-'.$value->id, $checked = false, ['class' => 'pull-right checkbox-trip checkbox-'.$today,'value'=>$value->id,'id'=>'checkbox-'.$value->id])."<br>";

        // Popover Start
        echo "<div id='".$value->id."' class='hidden panel panel-primary'>
          <div class='col-lg-12 popover-heading panel bg-primary'><center><strong>".$value->idBoat->idCompany->name."</strong><div class='pull-right'>".
          Html::a('', ['update','id'=>$value->id], ['class'=>'btn btn-xs btn-primary glyphicon glyphicon-pencil'])." ".
          Html::a('', ['delete', 'id' => $value->id], [
            'class' => 'btn btn-xs btn-danger glyphicon glyphicon-trash',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
          ]).
          "</div></center></div>
          <div class='popover-body list-group col-lg-12' >
          <div class='col-sm-3' style='font-weight:bold;'>Date</div><div class='col-sm-9'>".date('d-m-Y',strtotime($value->date))."</div>
          <div class='col-sm-3' style='font-weight:bold;'>Boat</div><div class='col-sm-9'>".$value->idBoat->name."</div>
          <div class='col-sm-3' style='font-weight:bold;'>Route</div><div class='col-sm-9'>".$value->idRoute->departureHarbor->name." -> ".$value->idRoute->arrivalHarbor->name."</div>
          <div class='col-sm-3'style='font-weight:bold;'>Avaibile</div><div class='col-sm-9'>".$value->stock."</div>";
          if ($value->status == 1) {
            echo "<div class='col-sm-3'style='font-weight:bold;'>Status</div><div class='col-sm-9 text-success'>ON</div>";
          }elseif($value->status == 2){
            echo "<div class='col-sm-3'style='font-weight:bold;'>Status</div><div class='col-sm-9  text-danger'>OFF</div>";
          }else{
            echo "<div class='col-sm-3'style='font-weight:bold;'>Status</div><div class='col-sm-9 bg-danger text-danger'>Blocked</div>";
          }
          echo "<div class='col-sm-12 bg-info'style='font-weight:bold;'>Price</div>
            <div class='col-sm-3'>Adult</div><div class='col-sm-9'>Rp &nbsp".number_format($value->adult_price,0)."</div>
            <div class='col-sm-3'>Child</div><div class='col-sm-9'>Rp &nbsp".number_format($value->child_price,0)."</div>
            ";
           
          echo "<div class='col-sm-3' style='font-weight:bold;'>Type</div>";
          if ($value->id_price_type != null) {
            echo "<div class='col-sm-9' style='font-weight:bold;'>".$value->idPriceType->type." price</div>";
          }else{
            echo "<div class='col-sm-9 text-danger' style='font-weight:bold;'>Unset price</div>";
          }
          

          

          if ($value->id_season == null) {
            echo "<div class='col-sm-12 bg-danger text-danger'style='font-weight:bold;'>Unset Session</div><br>&nbsp
          ";
          }else{
            echo "<div class='col-sm-12 bg-info'style='font-weight:bold;'>Season</div>
                 <div class='col-sm-3'>Type</div><div class='col-sm-9'>".$value->idSeason->idSeasonType->season."</div>
                  <div class='col-sm-3'>Start</div><div class='col-sm-9'>".date('d-m-Y',strtotime($value->idSeason->start_date))."</div>
                  <div class='col-sm-3'>End</div><div class='col-sm-9'>".date('d-m-Y',strtotime($value->idSeason->end_date))."</div>
                  ";
          }
          echo $value->description."</div> </div>";
          //popover end
      }
    }else{
      echo "<span class='text-danger'>Not Avaible</span>";
    }
    
    echo "</span></td>";

    //jika variabel w= 6 disini 6 adalah hari sabtu maka akan pindah baris dengan menutup baris </tr>
    if (date("w",mktime (0,0,0,$month,$d,$year)) == 6) { echo "</tr>"; }
}
echo '</table></tbody>';
?>
<?php Pjax::end(); ?></div>

</style>