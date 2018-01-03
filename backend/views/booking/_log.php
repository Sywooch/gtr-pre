<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TBooking */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="popover-body list-group col-lg-12">
<?php foreach($modelLog as $value): ?>
        <li style="padding: 5px 5px 5px 5px; text-align: left; font-size: 12px;" class="list-group-item">
            <span class="fa fa-user"></span> <?= $value['idUser']['username'] ?><br>
            <span class="fa fa-exchange"> <?= $value['idEvent']['event'] ?></span><br>
            <span class="fa fa-clock-o"> <?= date('d-m-Y H:i ',strtotime($value['datetime']))?></span><br>
            <?= $value['note'] != null ? '<span class="fa fa-sticky-note-o"></span> <b>'.$value['note']."</b><br>" : null ?>
        </li>
<?php endforeach; ?>
</div>