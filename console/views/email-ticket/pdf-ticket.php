<?php
use yii\helpers\Html;

require_once Yii::$app->basePath."/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
$tempdir = Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/"; //<-- Nama Folder file QR Code kita nantinya akan ?>



<?php foreach ($modelBooking as $key => $value): ?>
<div style="border-bottom: 2px solid #BDBDBD; padding-bottom: 25px;" class="col-md-12">
<span>
<span style="font-size: 20px;" class="pull-left">E-Ticket</span>
<img class="pull-right" src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" style="height:50px;">
</span>
</div>
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
        <span style="font-size: 10px;"><?= $value->idTrip->idBoat->name ?></span>
    </td>
    <td class="secondary-text" style="padding-top: 15px;">
      <?= date('H:i',strtotime($value->idTrip->dept_time)) ?> WITA<br>
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
      <?= $findPassenger->where(['id_booking'=>$value->id])->count() ?> Pax
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
<?php $shuttleList = $findShuttle->where(['id_booking'=>$value->id])->all(); ?>
<?php
if(!empty($shuttleList)):
  foreach($shuttleList as $indexShuttle => $valShuttle):
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
    <td><?= $valShuttle->idArea->area ?></td>
    <td><?= $valShuttle->location_name ?></td>
    <td><?= $valShuttle->address ?></td>
    <td><?= $valShuttle->phone ?></td>
  </tr>
</tbody>
</table>
<?php 
endforeach;
endif;
?>
<!-- Shuttle End -->

<!-- Passenger Table Start -->
<table class="table table-striped ">
  <caption><center>Passenger Detail</center></caption>
  <thead>
  <tr>
    <th>No.</th>
    <th>Name</th>
    <th>Nationality</th>
    <th>Type</th>
    <th>Date Of Birth</th>
  </tr>

  </thead>
  <tbody>

  <!-- Adult Start -->
<?php $adultList = $findPassenger->where(['id_booking'=>$value->id])->andWhere(['id_type'=>'1'])->all(); ?>
<?php foreach($adultList as $indexAdult => $valAdult): ?>
  <tr>
    <th scope="row"><?= $indexAdult+1 ?></th>
    <td><?= $valAdult->name?></td>
    <td><?= $valAdult->idNationality->nationality ?></td>
    <td>Adult</td>
    <td>-</td>
  </tr>
<?php endforeach;?>
  <!-- Adult End -->

  <!-- Child Start-->
  <?php $childList = $findPassenger->where(['id_booking'=>$value->id])->andWhere(['id_type'=>'2'])->orderBy(['birthday'=>SORT_ASC])->all(); ?>
  <?php if(!empty($childList)): ?>
  <?php foreach($childList as $indexChild => $valChild): ?>
  <tr>
    <th scope="row"><?= $indexAdult+$indexChild+2 ?></th>
    <td><?= $valChild->name ?></td>
    <td><?= $valChild->idNationality->nationality ?></td>
    <td>Child</td>
    <td><?= date('d-m-Y',strtotime( $valChild->birthday)) ?> </td>
  </tr>
  <?php endforeach;?>
<?php endif; ?>
  <!-- Child End -->
  <!-- Infants Start-->
  <?php $InfantList = $findPassenger->where(['id_booking'=>$value->id])->andWhere(['id_type'=>'3'])->orderBy(['birthday'=>SORT_ASC])->all(); ?>
<?php if(!empty($InfantList)): ?>
<?php foreach($InfantList as $indexinfants => $valInfant): ?>
  <tr>
    <th scope="row"><?= $indexAdult+$indexChild+$indexinfants+3 ?></th>
    <td><?= $valInfant->name ?></td>
    <td><?= $valInfant->idNationality->nationality ?></td>
    <td>Infants</td>
    <td><?= date('d-m-Y',strtotime($valInfant->birthday)) ?></td>
  </tr>
<?php endforeach;?>
<?php endif; ?>
<!-- Infants End -->

</tbody>
</table>
<!-- Passenger Table End -->

<!-- Contact Fastboat Start -->
<table class="table">
  <thead>
    <tr>
      
    </tr>
  </thead>
</table>
<!-- Conatact Fastbpat End-->
<div class="page-break"> </div>
<?php endforeach; ?>