<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TPrivateTrip */

$this->title = 'Create Private Trip';
$this->params['breadcrumbs'][] = ['label' => 'Private Trip', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-trip-create">


    <?= $this->render('_form', [
        'model' => $model,
        'listRoute' => $listRoute,
    ]) ?>

</div>
