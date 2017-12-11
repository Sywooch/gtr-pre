<?php

use yii\helpers\Html;
?>

<?=  Html::a(Html::img(["/content/thumbnail",'slug'=>$slug], [
		'class' => 'media-object material-media__object material-media__object_lg',
		'alt'=>'thumbnail'.$slug,
		'id'=>$slug,
		'onerror'=>'this.src="/thanks.png"'
]), '/fast-boats/'.$slug.''); ?>