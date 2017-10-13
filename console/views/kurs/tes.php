<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
<h2>
	
	<?php
foreach ($modelBooking as $key => $value) {
	echo $value->currency." = ".$value->kurs."<br>";
}
	 ?>
</h2>



