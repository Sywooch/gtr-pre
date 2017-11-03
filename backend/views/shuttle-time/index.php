<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TShuttleTimeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tshuttle Times');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-time-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tshuttle Time'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'idCompany.name',
            [
            'header'=>'Route',
            'format'=>'raw',
            'value'=>function($model){
                return $model->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idRoute->arrivalHarbor->name;
            },
            ],
            [
            'header'=>'Area Shuttle',
            'value'=>function($model){
                return $model->idArea->area;
            }
            ],
            'dept_time',
            'shuttle_time',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
