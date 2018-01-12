<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TShuttleLocation */

$this->title = Yii::t('app', 'Add Shuttle Location');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List Location'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
                'model' => $model,
                'listArea' => $listArea,
    ]) ?>

</div>
