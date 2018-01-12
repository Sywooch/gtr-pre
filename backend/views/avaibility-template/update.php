<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibilityTemplate */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Avaibility Template',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Template List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tavaibility-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany'=>$listCompany
    ]) ?>

</div>
