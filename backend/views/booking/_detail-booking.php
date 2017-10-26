<?php
use common\models\TPassenger;
use yii\helpers\Html;
?>

<table class="table table-stripped">
<thead>
<tr class="success">
	<th width="20px">No</th>
	<th width="20px"><center><span class="fa fa-money"></span></center></th>
	<th width="20px">Code</th>
	<th width="125px">Lead Name</th>
	<th width="125px">Phone</th>
	<th width="125px">Email</th>
	<th width="20px">Date</th>
	<th>Shuttle</th>
</tr>
</thead>
<tbody>
<?php foreach ($modelBooking as $key => $value): ?>
<tr>
	<td scope="row"><?= $key+1 ?></td>
	<td><?= Html::a('', $url = null, [
			'class' => 'btn btn-xs btn-default glyphicon glyphicon-modal-window',
			'data-toggle'=>'tooltip',
            'title'=>'View Payment Detail',
            'onclick'=>'
				$("#modal-'.$value->id.'").modal({
				});
            ',
			]); ?></td>
	<td rid="<?= $value->id ?>" class="header-row" scope="row"><?= $value->id ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->name ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->phone ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->email ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= date('d-m-Y',strtotime($value->idPayment->exp)) ?></td>
	<td rid="<?= $value->id ?>" class="header-row">
		<?php if(isset($value->tShuttles)){
			echo $value->tShuttles->idArea->area."-".$value->tShuttles->location_name." (".$value->tShuttles->address."-".$value->tShuttles->phone.")";
		}else{
			echo "-";
		}
		?>
	</td>
</tr>
<tr id="row-<?= $value->id ?>" style="display: none;">
<td colspan="6">
		<center><b style="text-decoration: underline;">Passenger Detail</b></center>
		<table style="margin-left: 100px;" hAlign="center" class="table">
		<thead>
		<tr class="info">
			<th width="20px">No</th>
			<th>Name</th>
			<th>Type</th>

		</tr>
		</thead>
		<tbody>
		<?php $Passengers = TPassenger::find()->where(['id_booking'=>$value->id])->all(); ?>
		<?php foreach($Passengers as $x => $valPasssenger): ?>
			<tr>
				<td scope="row"><?= $x+1 ?></td>
				<td><?= $valPasssenger->name ?></td>
				<td><?= $valPasssenger->idType->type ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
</td>
</tr>


<div class="modal material-modal material-modal_primary fade" id="modal-<?= $value->id ?>" style="display: none;">
 <div class="modal-dialog ">
	  <div class="modal-content material-modal__content">
		  <div class="modal-header material-modal__header">
			  <button class="close material-modal__close" data-dismiss="modal">&times;</button>
	                <h4 class="modal-title material-modal__title">Payment Detail</h4>
	        </div>
			<div class="modal-body material-modal__body">
				<li class="list-group-item"><?= $value->idPayment->name ?></li>
				<li class="list-group-item"><?= $value->idPayment->idPaymentMethod->method ?></li>
				<li class="list-group-item"><?= $value->idPayment->total_payment." ".$value->idPayment->currency ?></li>
				<li class="list-group-item"><?= "Rp ".number_format($value->idPayment->total_payment_idr,0) ?></li>
	        </div>
	        <div class="modal-footer material-modal__footer">
	                <button type="button" class="btn material-btn material-btn" data-dismiss="modal">Close</button>
	        </div>
        </div>
            <!-- /.modal-content -->
    </div>
          <!-- /.modal-dialog -->
</div>
<?php endforeach; ?>

</tbody>
</table>
<?php
$this->registerJs("
	$('.header-row').click(function(){
		var rid = $(this).attr('rid');
		$('#row-'+rid).toggle();
	});
	", \yii\web\View::POS_READY);
?>