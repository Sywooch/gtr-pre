<?php
require_once Yii::$app->basePath."/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/"; //<-- Nama Folder file QR Code kita nantinya akan 

$jumlahBooking = count($modelPayment->privateBookings)-1;

?>




<?php foreach ($modelPayment->privateBookings as $key => $value): ?>
<table cellspacing="0" width="100%" align="center">

<tr>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
    <span style="font-size: 20px; font-weight: bold;" class="pull-left">E-Ticket Private Transfers</span>
  </td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;"></td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;text-align: right;">
    <img src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" style="height:50px;"><br>
    <span style="text-align: center;" class="ports">reservation@gilitransfers.com / +62-813-5330-4990</span>
  </td>
</tr>

</table>

<?php 
$isi_teks = "http://gilitraansfers.com/".$modelPayment->token;
$namafile = "QrCode-".$value->id.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
?>
<!-- Trip description Start -->
<table cellspacing="0" width="100%" align="center">
  <tr>
    <td class="primary-text" colspan="4" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px; padding-top: 15px; text-align: center;font-weight: bold; font-size: 15px;">Trip Desctiption</td>
  </tr>
  <tr>
    <td style="padding: 15px 15px 15px 15px; width: 50px; border-bottom: 2px solid #BDBDBD;">
      From
    </td>
    <td style="padding: 15px 0px 15px 15px; border-bottom: 2px solid #BDBDBD;">
    :  <?= $value->idTrip->idRoute->fromRoute->location ?>
    </td>
    <td style="padding-top: 15px; border-bottom: 2px solid #BDBDBD;  vertical-align: middle; text-align: center;" rowspan="2">
    <?=  date('l, d F Y',strtotime($value->date_trip))."<br>".date('H:i',strtotime($value->date_trip)) ?>
    </td>
    <td align="center" class="secondary-text" rowspan="2" style="padding-top: 15px; border-bottom: 2px solid #BDBDBD; padding-bottom: 15px; width: 100px;">
     <img class="img-responsive pull-right" alt="QrCode" style="width:10%; height:10%;" src="<?php echo $tempdir.$namafile ?>" border="0"><br>
     <b style="text-align: center; color: #212121"><?= $value->id ?></b>
    </td>
  </tr>

  <!-- Row 3 -->
  <tr>
    <td style="border-bottom: 2px solid #BDBDBD; padding: 15px 15px 15px 15px;">
      To 
    </td>
    <td style="padding: 15px 0px 15px 15px; border-bottom: 2px solid #BDBDBD;">
    :  <?= $value->idTrip->idRoute->toRoute->location ?>
    </td>
    
  </tr>
</table>
<!-- Trip description End -->
<br>

<!-- Additional Info Start -->
<?php if($value->note == null || $value->note == " "):?>

<?php else: ?>
<table class="table">
  <caption>Additional Information </caption>
  <tbody>
   <tr>
      <td><?= $value->note ?></td>
    </tr>
  </tbody>
</table>
<?php endif; ?>

<!-- Additional Info End -->



<!-- Buyer Detail Start -->
<table class="table table-striped ">
  <caption>Buyer/Contact Detail</caption>
  <thead>
  <tr>
    <th>Name</th>
    <th width="175">Phone</th>
    <th width="174">Email</th>
  </tr>

  </thead>
  <tbody>
  <tr>
    <td><?= $modelPayment->name?></td>
    <td><?= $modelPayment->phone ?></td>
    <td><?= $modelPayment->email ?></td>

  </tr>
</tbody>
</table>
<!-- Buyer Detail End -->

<!-- Passenger Table Start -->
<table class="table table-striped ">
  <caption><center>Passengers Detail</center></caption>
  <thead>
  <tr>
    <th width="20">No.</th>
    <th>Name</th>
    <th width="175">Nationality</th>
    <th width="100">Type</th>
  </tr>

  </thead>
  <tbody>
<?php foreach($value->tPassengers as $indexAdult => $valAdult): ?>
  <tr>
    <th scope="row"><?= $indexAdult+1 ?></th>
    <td><?= $valAdult->name?></td>
    <td><?= $valAdult->idNationality->nationality ?></td>
    <td><?= $valAdult->idType->type ?></td>

  </tr>
<?php endforeach;?>
</tbody>
</table>
<!-- Passenger Table End -->

<?php if($key < $jumlahBooking): ?>
<div class="page-break"> </div>
<?php endif; ?>
<?php endforeach; ?>