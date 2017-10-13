<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPriceSet */

$this->title = Yii::t('app', 'Add Season Price Reference');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Season Price Reference'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tseason-price-set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany'=>$listCompany,
        'listRoute'=>$listRoute,
    ]) ?>

</div>
