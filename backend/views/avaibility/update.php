<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibility */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Avaibility',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avaibility List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tavaibility-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
