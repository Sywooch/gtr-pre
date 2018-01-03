<?php
use yii\helpers\Html;
?>
<div class="row">
<div class="col-md-12">
<p>
<span class="glyphicon glyphicon-check"> <?= $modelBooking->id ?> /</span>
<span> <?= $modelBooking->idTrip->idBoat->idCompany->name ?> </span> /
<span> <?= $modelBooking->idTrip->idRoute->departureHarbor->name." <i class=\"glyphicon glyphicon-arrow-right\"></i> ".$modelBooking->idTrip->idRoute->arrivalHarbor->name ?></span> / 
<span class="fa fa-clock-o"> <?= date('H:i',strtotime($modelBooking->idTrip->dept_time)) ?></span>
</p>
<div class="panel-group material-accordion material-accordion_primary" id="booking-Detail<?= $modelBooking->id ?>">
	<div class="panel panel-default material-accordion__panel">
		<div class="panel-heading material-accordion__heading">
			<h4 class="panel-title">
						<a class="collapsed material-accordion__title" data-toggle="collapse" data-parent="#booking-Detail<?= $modelBooking->id ?>" href="#passenger-detail<?= $modelBooking->id ?>"><span class="glyphicon glyphicon-user"></span> Passenger Detail <?= count($modelBooking->affectedPassengers) ?> *</a>
					</h4>
		</div>
		<div id="passenger-detail<?= $modelBooking->id ?>" class="panel-collapse collapse in material-accordion__collapse">
			<div class="panel-body">
					<div class="row">
					<div class="col-md-12">
						<table class="table table-stripped">
						<thead>
							<tr class="warning">
								<th scope="row" width="10px;">No</th>
								<th width="125px">Name</th>
								<th width="125px">Nationality</th>
								<th width="125px">Type</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($modelBooking->adultPassengers as $x => $valAdult): $no = $x+1;?>
							<tr>
								<td scope="row"><?= $no ?></td>
								<td><?= $valAdult->name ?></td>
								<td width="125px"><?= $valAdult->idNationality->nationality ?></td>
								<td width="125px">Adult</td>
							</tr>
						<?php endforeach; ?>
						<?php if(!empty($modelBooking->childPassengers)): ?>
						<?php foreach($modelBooking->childPassengers as $xc => $valChild): $noc = $no+$xc+1; ?>
							<tr>
								<td scope="row"><?= $noc ?></td>
								<td><?= $valChild->name ?></td>
								<td width="125px"><?= $valChild->idNationality->nationality ?></td>
								<td width="125px">Child</td>
							</tr>
						<?php endforeach; ?>
						<?php endif;?>
						<?php if(!empty($modelBooking->infantPassengers)): ?>
						<?php foreach($modelBooking->infantPassengers as $xi => $valInfant): $noi = $noc+$xi+1; ?>
							<tr>
								<td scope="row"><?= $noi ?></td>
								<td><?= $valInfant->name ?></td>
								<td width="125px"><?= $valInfant->idNationality->nationality ?></td>
								<td width="125px">Infant</td>
							</tr>
						<?php endforeach; ?>
						<?php endif;?>
						</tbody>
						</table>

						</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
</div>
</div> 
<i class="fa fa-exclamation"><b class="text-danger"> *Infant Not Included </b></i>
<style type="text/css">
	.custom-underline{
		border-bottom: 2px solid #455A64;
	}
	.font-tebal{
		font-weight: bold;
	}
</style>