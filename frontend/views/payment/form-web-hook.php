<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
$this->title = 'Test Web Hook';


?>


<?= Html::beginForm(['web-hook'], 'post') ?>
<label class="label-cotnorl">Nama</label>
<?= Html::textInput('nama', '', ['class' => 'form-control','placeholder'=>'Nama']); ?>
<label class="label-cotnorl">Alamat</label>
<?= Html::textInput('alamat', '', ['class' => 'form-control','placeholder'=>'Akamat']); ?>

<?= Html::submitButton('Send', ['class' => 'btn btn-danger btn-lg']); ?>
<?= Html::endForm() ?>