<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TPrivateRoute */

$this->title = 'Create Tprivate Route';
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-route-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listLocation' => $listLocation,
    ]) ?>

</div>
