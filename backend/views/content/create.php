<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TContent */

$this->title = 'Create Content';
$this->params['breadcrumbs'][] = ['label' => 'Content List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcontent-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listType' => $listType,
        'listSlug' => $listSlug,
        'listKeywords' => $listKeywords,
    ]) ?>

</div>
