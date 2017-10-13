<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TShuttlePrice */

$this->title = Yii::t('app', 'Create Tshuttle Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tshuttle Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
