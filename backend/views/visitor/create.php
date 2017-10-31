<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TVisitor */

$this->title = Yii::t('app', 'Create Tvisitor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tvisitors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tvisitor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
