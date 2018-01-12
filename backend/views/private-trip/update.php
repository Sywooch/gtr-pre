<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TPrivateTrip */

$this->title = 'Update Tprivate Trip: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Trips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tprivate-trip-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listRoute' => $listRoute,
        'listTime' => $listTime,
    ]) ?>

</div>
