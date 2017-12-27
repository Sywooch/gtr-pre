<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TPrivateRouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tprivate Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-route-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-lg btn-danger glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'header'=>'From',
            'value'=>'fromRoute.location',
            ],
            [
            'header'=>'To',
            'value'=>'toRoute.location',
            ],
            

            [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
