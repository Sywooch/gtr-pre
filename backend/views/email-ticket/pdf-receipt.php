<?php
use yii\helpers\Html;


?>
<table cellspacing="0" width="100%" align="center">

<tr>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;">
    <span style="font-size: 20px; font-weight: bold;" class="pull-left">Receipt</span>
  </td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;"></td>
  <td style="border-bottom: 2px solid #BDBDBD; padding-bottom: 15px;text-align: right;">
    <img src="<?= Yii::$app->basePath."/E-Ticket/logo.png" ?>" style="height:30px;"><br>
    <span style="text-align: center; " class="ports text-muted">reservation@gilitransfers.com / +62-813-5330-4990</span>
    </td>
</tr>

</table>

<?php 
$tokenPayment = "https://gilitraansfers.com/site/book-view/".$modelPayment->token;
$tokenQrfileName = "QrCode-".$modelPayment->token.".png";
$quality = 'L'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 1; //batasan 1 paling kecil, 10 paling besar
$padding = 1;
QRCode::png($tokenPayment,$tempdir.$tokenQrfileName,$quality,$ukuran,$padding);
?>

  <b align="center" class="judul">
    <img class="pull-right" alt="Logo" style="width:10%; height:10%;" src="<?php echo $tempdir.$tokenQrfileName ?>" border="0">
  </b>

<!-- Buyer Detail Start -->
<br>
<table class="table table-striped ">
  <caption><center>Buyer Detail</center></caption>
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


<table class="table table-striped ">
  <caption><center>PURCHASE DETAILS</center></caption>
  <thead>
  <tr>
    <th width="20">No.</th>
    <th>Name Of Item</th>
    <th width="175">Qty *</th>
    <th width="100">Price</th>
  </tr>

  </thead>
  <tbody>
<?php foreach ($modelBooking as $key => $value): ?>
  <tr>
    <th scope="row"><?= $key+1 ?></th>
    <td ><?= $value->idTrip->idBoat->idCompany->name." | ".$value->idTrip->idRoute->departureHarbor->name." -> ".$value->idTrip->idRoute->arrivalHarbor->name." | ".date('D, d M Y',strtotime($value->idTrip->date)) ?></td>
    <td >
      <span><?= count($value->affectedPassengers) ?> Pax</span>
      <br>
      
    </td>
    <td >
      <span><?= $value->currency." ".$value->total_price ?></span><br>
      <span style="color: #616161; font-size: 10px;">IDR <?= number_format($value->total_idr,0) ?></span>
    </td>

  </tr>


<?php endforeach; ?>
<tr>
  <td style="border-top: 1.5px solid black;">
    
  </td>
  <td style="border-top: 1.5px solid black;">
    
  </td>
  <td style="border-top: 1.5px solid black; font-weight: bold">
    Grand Total
  </td>
  <td style="border-top: 1.5px solid black; font-weight: bold">
    <span><?= $modelPayment->currency." ".$modelPayment->total_payment ?></span>
    <br>
    <span style="color: #616161; font-size: 10px;">IDR <?= number_format($modelPayment->total_payment_idr,0) ?></span>
  </td>
</tr>
</tbody>
</table>
<span style="font-size: 10px;" class="ports text-danger">*Infant not Included</span>
<img src="<?= Yii::$app->basePath."/E-Ticket/stamp.png" ?>">
<!-- Passenger Table End -->

