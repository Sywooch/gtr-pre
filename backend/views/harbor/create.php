<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\THarbor */

$this->title = Yii::t('app', 'Add Harbor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Harbor List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tharbor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'island'=>$island,
    ]) ?>

</div>
