<?php

use yii\helpers\Html;
use common\models\TRoute;
use common\models\TBoat;
use yii\helpers\Url;
$customCss = <<< SCRIPT
	.rata-tengah{
		text-align: center;
	}

SCRIPT;
$this->registerCss($customCss);
?>
<div class="panel-group material-accordion material-accordion_primary" id="summary">
	<div class="panel panel-default material-accordion__panel material-accordion__panel">
        <div class="panel-heading material-accordion__heading" id="acc2_headingOne">
         <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#summary" href="#summary-tab" class="material-accordion__title">Trip Schedule Summary</a>
         </h4>
        </div>
        <div id="summary-tab" class="panel-collapse collapse in material-accordion__collapse">
          <div class="panel-body">
		<table class="table table-striped table-hover table-responsive">
		 <thead>
		 <tr>
			 <th class="bg-warning rata-tengah" style="vertical-align: middle;" rowspan="2">#</th>
			 <th class="bg-warning rata-tengah" style="vertical-align: middle;" rowspan="2">Company Name</th>
			 <th class="bg-warning rata-tengah" style="vertical-align: middle;" rowspan="2">Route</th>
			 <th class="bg-warning rata-tengah" style="vertical-align: middle;" rowspan="2">Time</th>
			 <th class="bg-warning rata-tengah" colspan="2">Date</th>
			 <th class="bg-warning rata-tengah" style="vertical-align: middle;" rowspan="2">View</th>
		 </tr>
		 <tr>
		 	 
			 <th class="bg-warning rata-tengah">Start</th>
			 <th class="bg-warning rata-tengah">End</th>

		 </tr>
		 </thead>
		 <tbody>
		 	
		<?php foreach ($ListTrip as $key => $value): ?>
		<?php
		$dept = TRoute::findOne($value['id_route']); 
		$Boat = TBoat::findOne($value['id_boat']);
		?>


		 <tr>
		 <th scope="row"><?= $key+1 ?></th>
		 	<td><?= $Boat->idCompany->name ?></td>
		 	<td><?= $dept->departureHarbor->name." -> ".$dept->arrivalHarbor->name ?></td>
		 	<td><?= date('H:i',strtotime($value['dept_time'])) ?></td>
		 	<td class="rata-tengah"><?= date('d-m-Y',strtotime($value['minDate'])) ?></td>
		 	<td class="rata-tengah"><?= date('d-m-Y',strtotime($value['maxDate'])) ?></td>
		 	<td class="rata-tengah">
		 		<?= Html::a('', $url = null, [
		 			'cid'=>$Boat->id_company,
		 			'route'=>$value['id_route'],
		 			'time' => $value['dept_time'],
		 			'class' =>'btn-view-schedule btn btn-xs btn-warning glyphicon glyphicon-calendar',
		 			'data-toggle'=>'tooltip',
		 			'title'=>'View Schedule',
		 			'data-placement'=>'left',
		 			]); ?></td>
		 	
		 </tr>

		<?php endforeach; ?>
		</tbody> </table>
</div>
</div>
</div>
</div>
<?php
$this->registerJs('
$(".btn-view-schedule").on("click",function(){
	var idc = $(this).attr("cid");
	var idr = $(this).attr("route");
	var time = $(this).attr("time");
	$("#div-schedule").html("<center>Please Wait...<br><img src=\'/spinner.svg\'></center>");
	  $.ajax({
	    url:"'.Url::to(["index"]).'",
	    type: "GET",
	    data:{
	    		company:idc,
	    		route: idr,
	    		time: time,
	    	},
	    success:function(data){
	      $("#div-schedule").html(data);
	    },
	    error:function(data){
	      $("#div-schedule").html("<center>Something Its Wrong...<br>Try To Reload Page</center>");
	    },
	  })
});
  ');
 ?>

 <!-- Preloader Script -->
 <?php
$this->registerJs('
$("#summary-trip").html("<center>Please Wait...<br><img src=\'/spinner.svg\'></center>");
  $.ajax({
    url:"'.Url::to(["summary-trip"]).'",
    type: "POST",
    success:function(data){
      $("#summary-trip").html(data);
    },
    error:function(data){
      $("#summary-trip").html("<center>Something Its Wrong...<br>try To Reload Page</center>");
    },
  })
  ');
 ?>