<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TKurs */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tkurs',
]) . $model->currency;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tkurs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->currency, 'url' => ['view', 'id' => $model->currency]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tkurs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
