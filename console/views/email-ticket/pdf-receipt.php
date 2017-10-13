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
  <img src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" width="200">
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

<tr>
<td width="30%">
Payment Method
</td>
  <td>: <?= $modelPayment->idPaymentMethod->method ?>
</td>
</tr>

<tr>
<td width="30%" style="border-bottom:2px solid #00BCD4;">
Total Payment
</td>
  <td style="border-bottom:2px solid #00BCD4;">: <?= $modelPayment->id_payment_method = '1' ? $modelPayment->currency.' '.$modelPayment->total_payment : 'IDR '.$modelPayment->total_payment_idr ?>
</td>
</tr>

</tbody>
</table>

<?php foreach ($modelBooking as $key => $value): ?>

<?php 
$isi_teks = "http://gilitraansfers.com/".$value->id;
$namafile = "QrCode-".$value->id.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
?>

  <b align="center" class="judul">
    <?= $value->id ?>
  </b>
  <img class="pull-right" alt="Logo" style="width:10%; height:10%;" src="<?php echo $tempdir.$namafile ?>" border="0">

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
  <td>: <?= $value->idTrip->idBoat->name ?>
</td>
</tr>

<tr>
<td width="30%">
Route
</td>
  <td>: <?= $value->idTrip->idRoute->departureHarbor->name." -> ".$value->idTrip->idRoute->arrivalHarbor->name ?>
</td>
</tr>

<tr>
<td width="30%">
Date Of Trip
</td>
  <td>: <?= date('d-m-Y',strtotime($value->idTrip->date)) ?>
</td>
</tr>

<tr>
<td width="30%">
Departure Time
</td>
  <td>: <?= date('H:i',strtotime($value->idTrip->dept_time)) ?> WITA
</td>
</tr>

<tr>
<td width="30%">
Total Passengers
</td>
  <td>: <?= $findPassenger->where(['id_booking'=>$value->id])->count() ?>
</td>
</tr>



</tbody>
</table>


<?php endforeach; ?>
<!-- Trip Description end-->