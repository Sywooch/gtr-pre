<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TShuttleLocation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Shuttle Location',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List Location'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tshuttle-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listArea' => $listArea,
    ]) ?>

</div>
