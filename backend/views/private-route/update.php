<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TPrivateRoute */

$this->title = 'Update Tprivate Route: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tprivate-route-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
