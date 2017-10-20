<?php
use yii\helpers\Html;
use kato\pickadate\Pickadate;

?>
<div class="row">


    <div id="div-dept-time" class="col-md-12">
        <?= Pickadate::widget([
              'isTime' => true,
              'name'=>'update-dept-time',
              'id'=>'form-update-dept-time',
              'pickadateOptions' => [
                'format'=> 'H:i',
                'interval'=>15,
              ],
            ]); ?>
    </div>
</div>