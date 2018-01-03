<?php
use yii\helpers\Html;
use kartik\label\LabelInPlace;

$config = ['template'=>"{input}\n{error}\n{hint}"];
?>
	<?= $form->field($valShuttle, "[$id]id_area",['template'=>"{input}\n{error}\n{hint}",'enableClientValidation' => false])->dropDownList($listPickup,['prompt'=>'Select Area','id'=>'drop-'.$id]); ?>
	<?= $form->field($valShuttle, "[$id]location_name",['template'=>"{input}\n{error}\n{hint}",'enableClientValidation' => false])->widget(LabelInPlace::classname(),
                          [
                          'options'=>['id'=>'form-location'.$id],
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-marker"></i>Hotel / Location Name',
                          ]
                          ); ?>
    <?= $form->field($valShuttle, "[$id]address",['template'=>"{input}\n{error}\n{hint}",'enableClientValidation' => false])->widget(LabelInPlace::classname(),
                          [
                          'options'=>['id'=>'form-address-'.$id],
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-marker"></i>Hotel / Address',
                          ]
                          ); ?>
    <?= $form->field($valShuttle, "[$id]phone",['template'=>"{input}\n{error}\n{hint}",'enableClientValidation' => false])->widget(LabelInPlace::classname(),
                          [
                          'options'=>['id'=>'form-phone-'.$id],
                          'defaultIndicators'=>false,
                          'encodeLabel'=> false,
                          'label'=>'<i class="glyphicon glyphicon-phone"></i>Phone Number (optional)',
                          ]
                          ); ?>
    <?= Html::activeHiddenInput($valShuttle, "[$id]type", ['value' => $type]); ?>
