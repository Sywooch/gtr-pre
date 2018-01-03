<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TAvaibility */

$this->title = Yii::t('app', 'Add Avaibility');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Avaibility List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tavaibility-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
