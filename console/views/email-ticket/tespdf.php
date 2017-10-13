<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
?>
<div class="site-about">
    <h1>INI TEST HALAMAN UNTUK PDF</h1>

</div>
<h2>
	
	<?php
foreach ($modelBooking as $key => $value) {
	echo $value->currency." = ".$value->kurs."<br>";
}
	 ?>
</h2>



