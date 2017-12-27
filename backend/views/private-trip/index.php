<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TPrivateTripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tprivate Trips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tprivate-trip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tprivate Trip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'header'=>'Route',
            'format'=>'raw',
            'attribute'=>'id_route',
            'value'=>function($model){
                return $model->idRoute->fromRoute->location." <span class='fa fa-arrow-right'> </span>".$model->idRoute->toRoute->location;
            }
            ],
            [
            'header'=>'Timing',
            'format'=>'raw',
            'value'=>function($model){
                return $model->minTime->time." - ".$model->maxTime->time;
            }
            ],
            [
            'header'=>'Pricing',
            'format'=>'raw',
            'value'=>function($model){
                return "Rp ".number_format($model->min_price,0)." Max ".$model->max_person." Pax | Extra Pax @ Rp".number_format($model->person_price,0);
            }
            ],
            'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
