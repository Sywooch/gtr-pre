<?php

use yii\helpers\Html;

$customCss = <<< SCRIPT
.boat-logo{
  width: auto;
  height:50px;
  max-height: 50px;
  max-width: 300px;
}
.header-trip{
	font-size :20px;
}
.fa-small{
	font-size:15px;
}
SCRIPT;
$this->registerCss($customCss);
?>
<li class="list-group-item">
<?= Html::img(['/company/logo','logo'=>$company['logo_path']], ['class' => 'boat-logo']); ?>
<span class="header-trip"> <span class="fa fa-small fa-random"> </span> <?= $route->departureHarbor->name." <span class='fa fa-small fa-arrow-right'> </span> ".$route->arrivalHarbor->name." <span class='fa fa-small fa-clock-o'> </span> ".date('H:i',strtotime($time))." <span class='fa fa-small fa-phone'> </span> ".$company['phone']." <span class='fa fa-small fa-envelope'> </span> ".$company['email_bali']."/".$company['email_gili'] ?>
</span>
</li>