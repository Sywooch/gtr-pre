<?php
use yii\helpers\Html;

require_once Yii::$app->basePath."/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
//if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
    //mkdir($tempdir);
#parameter inputan



?>
<div class="col-md-12">
<div class="col-md-3">
  <img src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" width="100">
</div>
</div>
<?php 
$tokenPayment = "http://gilitraansfers.com/".$modelPayment->token;
$tokenQrfileName = "QrCode-".$modelPayment->token.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($tokenPayment,$tempdir.$tokenQrfileName,$quality,$ukuran,$padding);
?>

  <b align="center" class="judul">
    <img class="pull-right" alt="Logo" style="width:10%; height:10%;" src="<?php echo $tempdir.$tokenQrfileName ?>" border="0">
  </b>
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>
<tr>
<td style="background-color: #00BCD4; border-top:2px solid #00BCD4; border-bottom:2px solid #00BCD4;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
Customer Data
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #00BCD4;border-right:none;border-left:none;color: #333333 !important;">
</td>
</tr>
<tr>
<td width="30%">
Name
</td>
  <td>: <?= $modelPayment->name?>
</td>
</tr>

<tr>
<td width="30%">
Email
</td>
  <td>: <?= $modelPayment->email ?>
</td>
</tr>

<tr>
<td width="30%">
Phone
</td>
  <td>: <?= $modelPayment->phone ?>
</td>
</tr>


</tbody>
</table>
<div class="page-break"> </div>
<?php 
$isi_teks = "http://gilitraansfers.com/".$modelPayment->token;
$namafile = "QrCode-".$modelBooking->id.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
?>
  <img alt="Logo" style="height:50px;" src="<?= $modelBooking->idTrip->idBoat->idCompany->logo_path ?>" border="0">
  <img class="pull-right" alt="QrCode" style="width:10%; height:10%;" src="<?php echo $tempdir.$namafile ?>" border="0">

<!-- Trip Description start-->
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>

<tr>


  <td style="background-color: #ccc; border-top:2px solid #ccc; border-bottom:2px solid #ccc;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
Trip Description
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #ccc;border-right:none;border-left:none;color: #333333 !important;">

</td>


</tr>
<tr>
<td width="30%">
Boat
</td>
  <td>: <?= $modelBooking->idTrip->idBoat->name ?>
</td>
</tr>

<tr>
<td width="30%">
Route
</td>
  <td>: <?= $modelBooking->idTrip->idRoute->departureHarbor->name." -> ".$modelBooking->idTrip->idRoute->arrivalHarbor->name ?>
</td>
</tr>

<tr>
<td width="30%">
Date Of Trip
</td>
  <td>: <?= date('d-m-Y',strtotime($modelBooking->idTrip->date)) ?>
</td>
</tr>

<tr>
<td width="30%">
Departure Time
</td>
  <td>: <?= date('H:i',strtotime($modelBooking->idTrip->dept_time)) ?> WITA
</td>
</tr>
<tr>
<td width="30%">
Total Passengers
</td>
  <td>: <?= $findPassenger->where(['id_booking'=>$modelBooking->id])->count() ?>
</td>
</tr>



</tbody>
</table>
<!-- Trip Description End-->
<?php $shuttleList = $findShuttle->where(['id_booking'=>$modelBooking->id])->all(); ?>
<?php
if(!empty($shuttleList)):
  foreach($shuttleList as $indexShuttle => $valShuttle):
 ?>
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>

<tr>


  <td style="background-color:  #ccc; border-top:2px solid  #ccc; border-bottom:2px solid  #ccc;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
<?php if($modelBooking->idTrip->idRoute->departureHarbor->id_island == '1'){ echo 'Pickup';}else{ echo 'Drop Off';} ?>
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #ccc;border-right:none;border-left:none;color: #333333 !important;">

</td>


</tr>
<tr>
<td width="30%">
Area
</td>
  <td>: <?= $valShuttle->idArea->area ?>
</td>
</tr>

<tr>
<td width="30%">
Location
</td>
  <td>: <?= $valShuttle->location_name ?>
</td>
</tr>

<tr>
<td width="30%">
Address
</td>
  <td>: <?= $valShuttle->address ?>
</td>
</tr>

<tr>
<td width="30%">
Phone
</td>
  <td>: <?= $valShuttle->phone ?>
</td>
</tr>
</tbody>
</table>

<?php 
endforeach;
endif;
?>
<!-- Pickup End-->

<!-- Adult Start-->
<?php $adultList = $findPassenger->where(['id_booking'=>$modelBooking->id])->andWhere(['id_type'=>'1'])->all(); ?>
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>
<tr>
<td style="background-color: #00BCD4; border-top:2px solid #00BCD4; border-bottom:2px solid #00BCD4;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
Adult Passengers
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #00BCD4;border-right:none;border-left:none;color: #333333 !important;">
</td>
</tr>

<?php foreach($adultList as $indexAdult => $valAdult): ?>

<tr>
<td width="30%">
Name
</td>
  <td>: <?= $valAdult->name?>
</td>
</tr>

<tr>
<td width="30%" style="border-bottom:2px solid #00BCD4;">
Nationality
</td>
  <td style="border-bottom:2px solid #00BCD4;">: <?= $valAdult->idNationality->nationality ?>
</td>
</tr>



<?php endforeach;?>
</tbody>
</table>
<!-- Adult End -->

<!-- Child Start-->
<?php $childList = $findPassenger->where(['id_booking'=>$modelBooking->id])->andWhere(['id_type'=>'2'])->orderBy(['birthday'=>SORT_ASC])->all(); ?>
<?php if(!empty($childList)): ?>
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>
<tr>
<td style="background-color: #FFC400; border-top:2px solid #FFC400; border-bottom:2px solid #FFC400;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
Child Passengers
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #FFC400;border-right:none;border-left:none;color: #333333 !important;">
</td>
</tr>

<?php foreach($childList as $indexChild => $valChild): ?>

<tr>
<td width="30%">
Name
</td>
  <td>: <?= $valChild->name ?>
</td>
</tr>

<tr>
<td width="30%">
Birtday
</td>
  <td>: <?= date('d-m-Y',strtotime( $valChild->birthday)) ?> 
</td>
</tr>

<tr>
<td width="30%" style="border-bottom:2px solid #FFC400;">
Nationality
</td>
  <td style="border-bottom:2px solid #FFC400;">: <?= $valChild->idNationality->nationality ?>
</td>
</tr>



<?php endforeach;?>
</tbody>
</table>
<?php endif; ?>
<!-- Child End -->

<!-- Infants Start-->
<?php $InfantList = $findPassenger->where(['id_booking'=>$modelBooking->id])->andWhere(['id_type'=>'3'])->orderBy(['birthday'=>SORT_ASC])->all(); ?>
<?php if(!empty($InfantList)): ?>
<table class="table table-striped" style="margin-bottom: 20px;" width="100%" align="center">
<tbody>
<tr>
<td style="background-color: #FFFF00; border-top:2px solid #FFFF00; border-bottom:2px solid #FFFF00;border-right:none;border-left:none;padding-top:10px;padding-right: 5px; padding-bottom: 10px; padding-left: 15px;color: #333333 !important; font-weight:bold;">
Infant Passengers
</td>
<td style="text-align: right;border-top: none; border-bottom:2px solid #FFFF00;border-right:none;border-left:none;color: #333333 !important;">
</td>
</tr>

<?php foreach($InfantList as $indexinfants => $valInfant): ?>

<tr>
<td width="30%">
Name
</td>
  <td>: <?= $valInfant->name ?>
</td>
</tr>

<tr>
<td width="30%">
Birtday
</td>
  <td>: <?= date('d-m-Y',strtotime($valInfant->birthday)) ?> 
</td>
</tr>

<tr>
<td width="30%" style="border-bottom:2px solid #FFFF00;">
Nationality
</td>
  <td style="border-bottom:2px solid #FFFF00;">: <?= $valInfant->idNationality->nationality ?>
</td>
</tr>



<?php endforeach;?>
</tbody>
</table>
<?php endif; ?>
<!-- Infants End -->

<div class="page-break"> </div>
