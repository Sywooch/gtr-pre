<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TAvaibilityTemplate */

$this->title = Yii::t('app', 'Add Avaibility Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Template List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tavaibility-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany'=>$listCompany,
        'modelDatetime' => $modelDatetime,
    ]) ?>

</div>
