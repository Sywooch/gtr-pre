<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TCompany */

$this->title = 'Update Company: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'COmpany List', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tcompany-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'avaibleUser' => $avaibleUser,
    ]) ?>

</div>
