<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TTypeContent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ttype Content',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ttype Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ttype-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
