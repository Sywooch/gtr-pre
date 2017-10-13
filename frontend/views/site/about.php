<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\TMailQueue;
use common\models\TPassenger;
use common\models\TBooking;
use common\models\TShuttleLocationTmp;
use common\models\TPayment;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>

<?php
$start_date = '2017-10-01';

$end_date = '2017-10-15';

$date_from_user = '2017-10-21';

//$hasil =  check_in_range($start_date, $end_date, $date_from_user);




  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
 // return ();

if ((($user_ts >= $start_ts) && ($user_ts <= $end_ts)) == 1) {
    echo "Di Dalamnya";
}else{
    echo "Diluarnya";
}

?>
