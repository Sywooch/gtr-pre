<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TTime */

$this->title = 'Create Ttime';
$this->params['breadcrumbs'][] = ['label' => 'Ttimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttime-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
