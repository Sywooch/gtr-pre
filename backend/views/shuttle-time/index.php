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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
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
            [
            'header'=>'Dept Time',
            'format'=>'raw',
            'value'=>function($model){
                return $model->dept_time;
            }
            ],
            [
            'header'=>'Shuttle Time',
            'format'=>'raw',
            'value'=>function($model){
                return $model->shuttle_time_start." <span class='fa fa-arrow-right'> </span> ".$model->shuttle_time_end;
            }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
