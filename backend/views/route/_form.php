<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\TRoute */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="troute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'departure')->dropdownList(
    		$listHarbor,
    		[
    		'id'=>'drop-depart',
    		'prompt'=>'-> Select Departure Harbor <-',
    		'onchange'=>'
    			var dptv = $("#drop-depart").val();
    			$.ajax({
    				url: "'.Url::to("arrival-list").'",
    				type:"POST",
    				data:{dpt :dptv},
    				success: function (data) {
    					$("#drop-arriv").html(data);
    				}
    			});



    			',
    		]) ?>

    <?php 
    if ($model->isNewRecord) {
    	echo $form->field($model, 'arrival')->dropdownList([],['id'=>'drop-arriv','prompt'=>'-> Select Departure Harbor First <-']); 
    }else{
    	echo $form->field($model, 'arrival')->dropdownList($listHarbor,['id'=>'drop-arriv']); 
    }

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
