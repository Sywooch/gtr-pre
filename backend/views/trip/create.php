<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TTrip */

$this->title = Yii::t('app', 'Add Trip');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trip List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttrip-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany'=>$listCompany,
        'listRoute'=>$listRoute,
        'modelSeasonPrice'=>$modelSeasonPrice,
        'template' => $template,
        'est_time' => $est_time,
        'listBoat' => $listBoat,

    ]) ?>

</div>
