<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TPrivateLocation */

$this->title = 'Update Tprivate Location: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tprivate-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
