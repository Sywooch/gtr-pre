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

            'id',
            'id_route',
            'min_price',
            'max_person',
            'person_price',
            // 'min_time:datetime',
            // 'max_time:datetime',
            // 'datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
