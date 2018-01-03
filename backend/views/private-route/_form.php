<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\TPrivateRoute */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="tprivate-route-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_route')->dropDownList($listLocation, [
    	'prompt' =>'Select Departure...',
		'id'       => 'drop-from',
		'onchange' => '
    		var from = $(this).val();
    		if (from != "") {
    			$.ajax({
    				url: "'.Url::to(["to-route"]).'",
    				type: "POST",
    				data:{id: from},
    				success: function(data){
    					$("#drop-to").html(data);
    				}
    			})
    		}
    	'
    	]); ?>

    <?= $form->field($model, 'to_route')->dropDownList([], [
		'prompt' =>'Select From First...',
		'id'     => 'drop-to',

    	]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
