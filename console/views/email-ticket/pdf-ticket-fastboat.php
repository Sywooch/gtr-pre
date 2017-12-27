<?php
use common\models\TShuttleTime;


require_once Yii::$app->basePath."/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/"; //<-- Nama Folder file QR Code kita nantinya akan 

$jumlahBooking = count($modelPayment->tBookings)-1;

?>




<?php foreach ($modelPayment->tBookings as $key => $value): ?>
<table cellspacing="0" width="100%" align="center">

<tr>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
    <span style="font-size: 20px; font-weight: bold;" class="pull-left">E-Ticket Fastboat</span>
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
    <td class="primary-text" colspan="4" style="border-bottom: 2px solid #BDBDBD;padding-bottom: 15px; padding-top: 15px; text-align: center;font-weight: bold; font-size: 15px;"><?= date('l, d F Y',strtotime($value->idTrip->date)) ?></td>
  </tr>
  <tr>
    <td class="secondary-text" rowspan="2" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px; padding-top: 15px;">
       <img alt="Logo" style="width:100px;" src="<?= $value->idTrip->idBoat->idCompany->logo_path ?>" border="0"><br>
        <span style="text-align: center; font-weight: bold; color: #212121"><?= $value->idTrip->idBoat->idCompany->name ?></span><br>
        <span style="font-size: 11px;"><?= $value->idTrip->idBoat->idCompany->phone ?></span><br>
    </td>
    <td class="secondary-text" style="padding-top: 15px;">
      <?= date('H:i',strtotime($value->idTrip->dept_time)) ?><br>
      <?= $value->idTrip->idEstTime->est_time ?>
    </td>
    <td class="secondary-text" style="padding-top: 15px; border-bottom: 1.5px solid #BDBDBD;">
      <span class="island"><?= $value->idTrip->idRoute->departureHarbor->idIsland->island ?></span><br>
      <span class="ports"><?= $value->idTrip->idRoute->departureHarbor->name ?></span>

    </td>
    <td align="center" class="secondary-text" rowspan="2" style="padding-top: 15px; border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
     <img class="img-responsive pull-right" alt="QrCode" style="width:10%; height:10%;" src="<?php echo $tempdir.$namafile ?>" border="0"><br>
     <b style="text-align: center; color: #212121"><?= $value->id ?></b>
    </td>
  </tr>
  <tr>
    <td class="secondary-text" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
      <span><?= count($value->affectedPassengers) ?> Pax*</span>
      <br>
      <span style="font-size: 10px;" class="ports text-danger">*Infant not Included</span>
    </td>
    <td class="secondary-text" style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
      <span class="island"><?= $value->idTrip->idRoute->arrivalHarbor->idIsland->island ?></span><br>
      <span class="ports"><?= $value->idTrip->idRoute->arrivalHarbor->name ?></span>
    </td>
    
  </tr>
</table>
<span class="row secondary-text">
<?php if($value->idTrip->description == null || $value->idTrip->description == " "){

  }else{
    echo "Note:  This Trip ".$value->idTrip->description;
    } ?>
  

</span>

<!-- Trip description End -->

<!-- Shuttle Start -->
<?php
if(isset($value->tShuttles)):
  //foreach($shuttleList as $indexShuttle => $value->tShuttles):
 ?>

<table class="table">
  <caption><center><?php if($value->idTrip->idRoute->departureHarbor->id_island == '1'){ echo 'Pickup';}else{ echo 'Drop Off';} ?>  Detail</center></caption>
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
        echo $value->tShuttles->idArea->area;
        if($value->idTrip->idRoute->departureHarbor->id_island == '1'){
          if (($modelShuttleTime = TShuttleTime::find()->where(['id_company'=>$value->idTrip->idBoat->id_company,'id_route'=>$value->idTrip->id_route,'dept_time'=>$value->idTrip->dept_time,'id_area'=>$value->tShuttles->id_area])->one()) !== null) {
                  echo "<br> <i style='font-size: 10px;'>".date('H:i',strtotime($modelShuttleTime->shuttle_time_start))." - ".date('H:i',strtotime($modelShuttleTime->shuttle_time_end))."</i>";
              }else{
                  echo "";
              }
        }
         ?></td>
    <td><?= $value->tShuttles->location_name ?></td>
    <td><?= $value->tShuttles->address ?></td>
    <td><?= $value->tShuttles->phone ?></td>
  </tr>
</tbody>
</table>
<?php 
//endforeach;
endif;
?>
<!-- Shuttle End -->

<!-- Buyer Detail Start -->
<table class="table table-striped ">
  <caption><center>Buyer/Contact Detail</center></caption>
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