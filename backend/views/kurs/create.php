<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TKurs */

$this->title = Yii::t('app', 'Create Tkurs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tkurs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkurs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
