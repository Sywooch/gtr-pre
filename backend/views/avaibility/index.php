<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TAvaibilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Avaibility List');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .myclass{
        font-size: 100px;
    }
</style>
<div class="tavaibility-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'class'=>'myclass',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_trip',
            'idTrip.date',
            'type0.type',
            'stok',
            'sold',
            'process',
            'cancel',
            'datetime:datetime',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
