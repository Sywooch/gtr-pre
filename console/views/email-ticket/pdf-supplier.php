<?php
use yii\helpers\Html;
use common\models\TShuttleTime;

require_once Yii::$app->basePath."/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
//if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
    //mkdir($tempdir);
#parameter inputan



?>
<table cellspacing="0" width="100%" align="center">

<tr>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
    <span style="font-size: 12px; font-weight: bold;" class="pull-left">Trip Detail</span>
  </td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;"></td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;text-align: right;">
    <img src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" style="height:40px;"><br>
    <span style="text-align: center;" class="ports">reservation@gilitransfers.com / +62-813-5330-4990</span>
    </td>
</tr>
</table>

<!-- Trip description Start -->
<table cellspacing="0" width="100%" align="center">
  <tr>
    <td class="primary-text" colspan="4" style="border-bottom: 2px solid #BDBDBD;padding-bottom: 15px; padding-top: 15px; text-align: center;font-weight: bold; font-size: 15px;"><?= date('l, d F Y',strtotime($modelBooking->idTrip->date)) ?></td>
  </tr>
  <tr>
    <td class="secondary-text" rowspan="2" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px; padding-top: 15px;">
       <img alt="Logo" style="width:100px;" src="<?= $modelBooking->idTrip->idBoat->idCompany->logo_path ?>" border="0"><br>
        <span style="text-align: center; font-weight: bold; color: #212121"><?= $modelBooking->idTrip->idBoat->idCompany->name ?></span><br>
        <span style="font-size: 11px;"><?= $modelBooking->idTrip->idBoat->idCompany->phone ?></span><br>
    </td>
    <td class="secondary-text" style="padding-top: 15px;">
      <?= date('H:i',strtotime($modelBooking->idTrip->dept_time)) ?> WITA<br>
      <?= $modelBooking->idTrip->idEstTime->est_time ?>
    </td>
    <td class="secondary-text" style="padding-top: 15px; border-bottom: 1.5px solid #BDBDBD;">
      <span class="island"><?= $modelBooking->idTrip->idRoute->departureHarbor->idIsland->island ?></span><br>
      <span class="ports"><?= $modelBooking->idTrip->idRoute->departureHarbor->name ?></span>

    </td>
<?php 
$isi_teks = "http://gilitraansfers.com/".$modelPayment->token;
$namafile = "QrCode-".$modelBooking->id.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
?>
    <td align="center" class="secondary-text" rowspan="2" style="padding-top: 15px; border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
     <img class="img-responsive pull-right" alt="QrCode" style="width:10%; height:10%;" src="<?php echo $tempdir.$namafile ?>" border="0"><br>
     <b style="text-align: center; color: #212121"><?= $modelBooking->id ?></b>
    </td>
  </tr>
  <tr>
    <td class="secondary-text" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
      <?= $findPassenger->where(['id_booking'=>$modelBooking->id])->count() ?> Pax
    </td>
    <td class="secondary-text" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
      <span class="island"><?= $modelBooking->idTrip->idRoute->arrivalHarbor->idIsland->island ?></span><br>
      <span class="ports"><?= $modelBooking->idTrip->idRoute->arrivalHarbor->name ?></span>
    </td>
    
  </tr>
</table>

<!-- Buyer Detail Start -->
<br>
<table class="table table-striped ">
  <caption><center>Contact Detail</center></caption>
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

<!-- Shuttle Start -->
<?php
if(isset($modelBooking->tShuttles)):
  //foreach($shuttleList as $indexShuttle => $modelBooking->tShuttles):
 ?>

<table class="table">
  <caption><center><?php if($modelBooking->idTrip->idRoute->departureHarbor->id_island == '1'){ echo 'Pickup';}else{ echo 'Drop Off';} ?>  Detail</center></caption>
  <thead>
  <tr>
    <th>Area</th>
    <th>Location</th>
    <th>Address</th>
    <th>Phone</th>
  </tr>

  </thead>
  <tbody>
 <tr>
    <td><?php 
        echo $modelBooking->tShuttles->idArea->area;
        if($modelBooking->idTrip->idRoute->departureHarbor->id_island == '1'){
          if (($modelShuttleTime = TShuttleTime::find()->where(['id_company'=>$modelBooking->idTrip->idBoat->id_company,'id_route'=>$modelBooking->idTrip->id_route,'dept_time'=>$modelBooking->idTrip->dept_time,'id_area'=>$modelBooking->tShuttles->id_area])->one()) !== null) {
                  echo "<br> <i style='font-size: 10px;'>".date('H:i',strtotime($modelShuttleTime->shuttle_time_start))." - ".date('H:i',strtotime($modelShuttleTime->shuttle_time_end))."</i>";
              }else{
                  echo "";
              }
        }
         ?></td>
    <td><?= $modelBooking->tShuttles->location_name ?></td>
    <td><?= $modelBooking->tShuttles->address ?></td>
    <td><?= $modelBooking->tShuttles->phone ?></td>
  </tr>
</tbody>
</table>
<?php 
//endforeach;
endif;
?>
<!-- Shuttle End -->


<!-- Passenger Table Start -->
<table class="table table-striped ">
  <caption><center>Passenger Detail</center></caption>
  <thead>
  <tr>
    <th width="20">No.</th>
    <th>Name</th>
    <th width="175">Nationality</th>
    <th width="100">Type</th>
  </tr>

  </thead>
  <tbody>
<?php foreach($modelBooking->tPassengers as $indexAdult => $valAdult): ?>
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

<div class="page-break"> </div>
