<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TContent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Content',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Content List', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tcontent-update">

    <?= $this->render('_form', [
        'model' => $model,
		'listType' => $listType,
    	'listSlug' => $listSlug,
    	 'listKeywords' => $listKeywords,
    ]) ?>

</div>
