<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
?>
<h2>
	this is test pdf page
	<br>
	<?php
foreach ($modelBooking as $key => $value) {
	echo $value->currency." = ".$value->kurs."<br>";
}
	 ?>
</h2>
