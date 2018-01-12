<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TShuttleArea */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Shuttle Area',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shuttle Area'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tshuttle-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listIsland'=>$listIsland,
    ]) ?>

</div>
