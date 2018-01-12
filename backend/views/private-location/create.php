<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TPrivateLocation */

$this->title = 'Create Tprivate Location';
$this->params['breadcrumbs'][] = ['label' => 'Tprivate Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
