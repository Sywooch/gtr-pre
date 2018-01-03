<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TTypeContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Type Content';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttype-content-index">

    <p>
        <?= Html::a('', ['/type-content/create'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'type',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
