<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TCompany */

$this->title = 'Add Company';
$this->params['breadcrumbs'][] = ['label' => 'Company List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcompany-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'avaibleUser' => $avaibleUser,
    ]) ?>

</div>
