<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TSeasonPriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Season Prices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tseason-price-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'idSeasonType.season',
            'idTrip.idBoat.idCompany.name',
            'idTrip.idBoat.name',
            'idTrip.date',
            'adult_price',
            'child_price',
            'infant_price',
            'start_date',
            'end_date',
          //  'datetime',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
