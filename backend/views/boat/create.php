<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TBoat */

$this->title = Yii::t('app', 'Add Boat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Boat List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tboat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'CompanyList'=>$CompanyList,
    ]) ?>

</div>
