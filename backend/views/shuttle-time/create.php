<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TShuttleTime */

$this->title = 'Add Shuttle Time';
$this->params['breadcrumbs'][] = ['label' => 'List Shuttle', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany' => $listCompany,
       // 'listArea' => $listArea,
    ]) ?>

</div>
