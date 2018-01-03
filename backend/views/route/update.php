<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TRoute */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Route',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Route List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="troute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listHarbor'=>$listHarbor,
    ]) ?>

</div>
