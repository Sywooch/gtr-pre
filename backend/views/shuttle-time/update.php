<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TShuttleTime */

$this->title = Yii::t('app', 'Update Shuttle Time ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'List Shuttle Time', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tshuttle-time-update">

    <?= $this->render('_form', [
        'model' => $model,
		'listCompany' => $listCompany,
		'listArea' => $listArea,
		'listRoute' => $listRoute,
		'listDeptTime' => $listDeptTime,
    ]) ?>

</div>
