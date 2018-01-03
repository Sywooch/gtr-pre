<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TBoat */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Boat',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Boat List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tboat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'CompanyList'=>$CompanyList,
    ]) ?>

</div>
