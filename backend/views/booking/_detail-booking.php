<?php
use common\models\TPassenger;
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<table class="table table-stripped">
<thead>
<tr class="success">
	<th width="20px">No</th>
		<th width="20px">Code</th>
	<th width="125px">Lead Name</th>
	<th width="125px">Phone</th>
	<th width="125px">Email</th>
	<th width="20px">Date</th>
	<th width="20px">Detail</th>
	<th>Shuttle</th>
	

</tr>
</thead>
<tbody>
<?php foreach ($modelBooking as $key => $value): $nomor = $key+1?>
<tr>
	<td scope="row"><?= $nomor ?></td>
	<td rid="<?= $value->id ?>" class="header-row" scope="row"><?= $value->id ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->name ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->phone ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= $value->idPayment->email ?></td>
	<td rid="<?= $value->id ?>" class="header-row"><?= date('d-m-Y',strtotime($value->idPayment->exp)) ?></td>
	<td><?= Html::a('', ['detail-modal','id_booking'=>$value->id], [
			'class' => 'btn btn-xs btn-warning glyphicon glyphicon-modal-window',
			'data-toggle'=>"modal",
			'data-target'=>"#my-".$value->id."",
			'data-title'=>"Detail Data",
			]); ?></td>
	<td rid="<?= $value->id ?>" class="header-row">
		<?php if(isset($value->tShuttles)){
			echo $value->tShuttles->idArea->area."-".$value->tShuttles->location_name." (".$value->tShuttles->address."-".$value->tShuttles->phone.")";
		}else{
			echo "-";
		}
		?>
	</td>
	

</tr>

<tr>
<td colspan="6">

</td>
</tr>
<?php if(count($modelBooking) == $nomor){
	echo "</tbody></table>";
}
?>

<?php endforeach; ?>
<?php foreach ($modelBooking as $key => $value):?>
<?php

Modal::begin([
	'id'=>'my-'.$value->id,
    'header' => '<h2>Booking Detail</h2>',
    'size'=>'modal-lg',
]);

echo '...';

Modal::end();

$this->registerJs("
	$('#my-".$value->id."').on('show.bs.modal', function (event) {
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
?>
<?php endforeach; ?>
