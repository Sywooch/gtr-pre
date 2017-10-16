<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HarborSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Port List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tharbor-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-lg btn-danger glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'idIsland.island',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
