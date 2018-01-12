<?php
use yii\helpers\Html;
?>
<div class="row">
<div class="col-md-12">
<p>
<span class="glyphicon glyphicon-check"><?= $modelBooking->id ?> /</span>
<span> <?= $modelBooking->idTrip->idRoute->fromRoute->location." <i class=\"glyphicon glyphicon-arrow-right\"></i> ".$modelBooking->idTrip->idRoute->toRoute->location ?></span> / 
<span class="fa fa-clock-o"> <?= date('d-m-Y H:i',strtotime($modelBooking->date_trip)) ?></span>
</p>
<div class="panel-group material-accordion material-accordion_primary" id="booking-Detail<?= $modelBooking->id ?>">
	<div class="panel panel-default material-accordion__panel material-accordion__panel">
		<div class="panel-heading material-accordion__heading" id="acc1_headingOne">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#booking-Detail<?= $modelBooking->id ?>" href="#payment<?= $modelBooking->id ?>" class="material-accordion__title"><span class="fa fa-money"></span> Price Detail*</a>
			</h4>
		</div>
		<div id="payment<?= $modelBooking->id ?>" class="panel-collapse collapse in material-accordion__collapse">
			<div class="panel-body">
					<div class="row">
					<div class="col-md-12">
						<table class="table table-stripped">
						<thead>
							<tr class="warning">
								<th width="125px">Pricing Scheme </th>
								<th width="125px">Amount</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$totalPax = count($modelBooking->affectedPassengers);
						$maxPax = $modelBooking->idTrip->max_person;
						?>

						<?php if($totalPax <= $maxPax): ?>
						<?php 
						$totalPrice = number_format($modelBooking->idTrip->min_price,0);
						$type = '('.$totalPax.' Pax) Minimal Price';
						?> 
						<?php else: ?>
						<?php
						$minPrice   = $modelBooking->idTrip->min_price;
						$extraPax   = $totalPax-$maxPax;
						$extraPrice = $modelBooking->idTrip->person_price*$extraPax;
						$totalPrice = number_format($minPrice+$extraPrice,0);
						$type = 'Person Price @ '.number_format($modelBooking->idTrip->person_price,0);
						?>
						<?php endif; ?>
						<tr>
							<td><?= $type ?></td>
							<td width="125px">Rp <?= $totalPrice ?></td>
						</tr>
						<tr>
							<td></td>
							<td class="font-tebal"><?= "Rp ".$totalPrice ?></td>
						</tr>
						</tbody>
						</table>
						</div>
					</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default material-accordion__panel">
		<div class="panel-heading material-accordion__heading">
			<h4 class="panel-title">
						<a class="collapsed material-accordion__title" data-toggle="collapse" data-parent="#booking-Detail<?= $modelBooking->id ?>" href="#passenger-detail<?= $modelBooking->id ?>"><span class="glyphicon glyphicon-user"></span> Passenger Detail <?= count($modelBooking->affectedPassengers) ?> *</a>
					</h4>
		</div>
		<div id="passenger-detail<?= $modelBooking->id ?>" class="panel-collapse collapse material-accordion__collapse">
			<div class="panel-body">
					<div class="row">
					<div class="col-md-12">
						<table class="table table-stripped">
						<thead>
							<tr class="warning">
								<th scope="row" width="10px">No</th>
								<th width="125px">Name</th>
								<th width="125px">Nationality</th>
								<th width="125px">Type</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($modelBooking->tPassengers as $x => $valPax): $no = $x+1;?>
							<tr>
								<td scope="row"><?= $no ?></td>
								<td><?= $valPax->name ?></td>
								<td width="125px"><?= $valPax->idNationality->nationality ?></td>
								<td width="125px"><?= $valPax->idType->type ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						</table>

						</div>
				</div>
			</div>
		</div>
	</div>
		<div class="panel panel-default material-accordion__panel">
		<div class="panel-heading material-accordion__heading">
			<h4 class="panel-title">
						<a class="collapsed material-accordion__title" data-toggle="collapse" data-parent="#booking-Detail<?= $modelBooking->id ?>" href="#related-booking-<?= $modelBooking->id ?>"><span class="glyphicon glyphicon-random"> </span> Related Trip & Payment Detail</a>
					</h4>
		</div>
		<div id="related-booking-<?= $modelBooking->id ?>" class="panel-collapse collapse material-accordion__collapse">
			<div class="panel-body">
					<div class="row">
					<div class="col-md-12">
						<table class="table table-stripped">
						<caption>Related Trip</caption>
						<thead>
							<tr class="warning">
								<th width="10px">No</th>
								<th width="50px">Code</th>
								<th width="125px">Operator</th>
								<th width="125px">Trip</th>
								<th width="50px">Pax*</th>
								<th width="125px">Date Of Trip</th>
								<th width="125px">Amount</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($modelBooking->idPayment->tPrivateBookings as $x => $valBookings): ?>
							<?php if($valBookings->id != $modelBooking->id): ?>
							<tr>
							 <td><?= $x+1 ?></td>
							 <td width="50"><?= $valBookings->id ?></td>
							 <td><?= isset($valBookings->idOperator) ? $valBookings->idOperator->name." | ".$valBookings->idOperator->phone." | ".$valBookings->idOperator->email : " <b class='text-danger'>Unset Operator </b>" ?></td>
							 <td><?= $valBookings->idTrip->idRoute->fromRoute->location." -> ".$valBookings->idTrip->idRoute->toRoute->location ?></td>
							 <td><?= count($valBookings->affectedPassengers) ?> Pax</td>
							 <td><?= date('d-m-Y H:i',strtotime($valBookings->date_trip)) ?></td>
							 <td>Rp <?= number_format($valBookings->amount_idr,0) ?></td>
							</tr>
						<?php else: ?>
							<tr class="info">
							 <td><?= $x+1 ?></td>
							 <td width="50"><?= $valBookings->id ?></td>
							 <td><?= isset($valBookings->idOperator) ? $valBookings->idOperator->name." | ".$valBookings->idOperator->phone." | ".$valBookings->idOperator->email : " <b class='text-danger'>Unset Operator </b>" ?></td>
							 <td><?= $valBookings->idTrip->idRoute->fromRoute->location." -> ".$valBookings->idTrip->idRoute->toRoute->location ?></td>
							 <td><?= count($valBookings->affectedPassengers) ?> Pax</td>
							 <td><?= date('d-m-Y H:i',strtotime($valBookings->date_trip)) ?></td>
							 <td>Rp <?= number_format($valBookings->amount_idr,0) ?></td>
							</tr>
						<?php endif; ?>
						<?php endforeach; ?>
							<tr>
								<td colspan="3"></td>
								<td style="border-top: 2px solid #455A64;" colspan="2">Current Rate <span class="font-tebal"> 1 <?= $modelBooking->idPayment->currency." =  Rp ".number_format($modelBooking->idPayment->exchange,0) ?></span></td>
								<td style="border-top: 2px solid #455A64;" class="font-tebal top-line"><?= $modelBooking->idPayment->idPaymentMethod->method ?></td>
								<td style="border-top: 2px solid #455A64;" class="font-tebal top-line">Rp <?= number_format($modelBooking->idPayment->total_payment_idr,0)."<br>".$modelBooking->idPayment->total_payment." ".$modelBooking->idPayment->currency  ?></td>
							</tr>
						</tbody>
						</table>
						<div class="alert material-alert material-alert_warning">Payment History</div>
						<!-- Payment History Start -->
						<!-- PAyapal Transaction Start -->
						<?php if($modelBooking->idPayment->id_payment_method == "1" && isset($modelBooking->idPayment->paypalTransaction)): ?>
						<table class="table table-stripped">
						 <caption>Payment Data From Paypal</caption>
							<thead>
							<tr class="danger">
								<th width="10px">ID</th>
								<th>Payer</th>
								<th width="10px">Amount</th>
								<th>Status</th>
								<th width="10px">Time</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $modelBooking->idPayment->paypalTransaction->id ?></td>
								<td><?= $modelBooking->idPayment->paypalTransaction->idPayer->full_name ?></td>
								<td><?= $modelBooking->idPayment->paypalTransaction->amount." ".$modelBooking->idPayment->paypalTransaction->currency ?></td>
								<td><?= $modelBooking->idPayment->paypalTransaction->idStatus->status ?></td>
								<td><?= date('d-m-Y H:i', strtotime($modelBooking->idPayment->paypalTransaction->datetime)) ?></td>
							</tr>
						</tbody>
						</table>

						<!-- PAyapal Transaction End -->
						<!-- WebHook Start -->
					<?php if(isset($modelBooking->idPayment->paypalTransaction->tWebhook)): ?>
						<table class="table table-stripped">
						 <caption>Notification From Paypal (WebHook)</caption>
							<thead>
							<tr class="success">
								<th width="10px">No</th>
								<th>Event</th>
								<th width="10px">Amount</th>
								<th>Status</th>
								<th width="10px">Time</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$webHookData = $modelBooking->idPayment->paypalTransaction->tWebhook;
						 foreach($webHookData as $index => $valWebHook): 
						 	$number = $index+1;
						?>
							<tr>
								<td><?= $number ?></td>
								<td><?= $valWebHook->idEvent->event ?></td>
								<td><?= $valWebHook->amount." ".$valWebHook->currency ?></td>
								<td><?= $valWebHook->idStatus->status ?></td>
								<td><?= date('d-m-Y H:i', strtotime($valWebHook->datetime)) ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
						</tbody>
						</table>
						<!-- WebHook End -->
						<?php elseif($modelBooking->idPayment->id_payment_method == "2" && isset($modelBooking->idPayment->confirmPayment)): ?>
							<table class="table table-stripped">
						 	<caption>Payment data Bank Transfers (From Customer)</caption>
							<thead>
								<tr class="success">
									<th width="10px">Token</th>
									<th>Payer</th>
									<th width="10px">Amount</th>
									<th>Status</th>
									<th width="10px">Time</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $modelBooking->idPayment->token ?></td>
									<td><?= $modelBooking->idPayment->confirmPayment->name ?></td>
									<td>Rp <?= number_format($modelBooking->idPayment->confirmPayment->amount,0) ?></td>
									<td><?= $modelBooking->idPayment->statusPayment->status ?></td>
									<td><?= date('d-m-Y H:i', strtotime($modelBooking->idPayment->exp)) ?></td>
								</tr>
							</tbody>
							</table>

							<center><?= Html::img(['payment-slip','id'=>$modelBooking->id_payment], ['class' => 'img-responsive','onerror'=>'this.src="/error.png"']); ?></center>
						<?php endif; ?>
						<!-- Payment History End -->

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