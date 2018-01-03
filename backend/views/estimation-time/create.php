<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TEstTime */

$this->title = Yii::t('app', 'Create Test Time');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Times'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
