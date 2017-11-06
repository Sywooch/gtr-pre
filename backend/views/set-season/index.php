<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\TCompany;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TSeasonPriceSetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Season Price Reference');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tseason-price-set-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-danger btn-lg glyphicon glyphicon-plus']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>['type'=>'info', 'heading'=>''],
        'export'=>false,
        'striped'      =>true,
        'bordered'  => true,
        'responsive'=>true,
        'hover'        =>true,
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
           // 'beforeGrid'=>'My fancy content before.',
            //'afterGrid'=>'My fancy content after.',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
            'header'=>'Company',
            'attribute'=>'id_company',
            'format'=>'raw',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<span class='fa fa-ship company'>".$model->idCompany->name."</span>";
            },
            'format'=>'raw',
            'group'             =>true,  // enable grouping,
            'groupedRow'        =>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'  =>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass' =>'kv-grouped-row', // configure even group cell css class
            ],
            [
            'header'=>'Company',
            'attribute'=>'id_company',
            'value'=>function($model){
              return " ";
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TCompany::find()->select('id,name')->asArray()->all(), 'id', 'name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Any Company...'],
            'width'=>'200px',
            ],
            [
            'header'=>'Departure',
            'attribute'=>'departure',
            'format'=>'raw' ,
            'width'=>'100px',
            'vAlign'=>'top',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<span class='route'>".$model->idRoute->departureHarbor->name."</span> ";
            },
            'group'=>true,  // enable grouping
            'groupedRow'        =>true,
            'subGroupOf'=>1, // supplier column index is the parent group,
            ],
            [
            'header'=>'<span class="fa fa-code-fork"> Route</span>',
            'format'=>'raw',
            'attribute'=>'id_route',
            'value'=>function($model){
                return $model->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idRoute->arrivalHarbor->name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Yii::$app->runAction('/trip/get-route'), 'id', 'route','island'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
                  ],
            'filterInputOptions'=>['placeholder'=>'Any Route...'],
            ],
            [
            'header'=>'Price<br><span class="fa fa-user">Adult</span>/<span class="fa fa-child">Child</span>',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($model){
                return "<br><span class='fa fa-user'> Rp </span> ".number_format($model->adult_price,0)." /<span class='fa fa-child'>  Rp </span> ".number_format($model->child_price,0)."/".$model->idSeasonType->season;
            }
            ],
            //'infant_price',
            [
            'header'=>'<span class="fa fa-calendar"> Affected Date</span>',
            'format'=>'raw',
            'value'=>function($model){
                return "<span> ".date('d-m-Y',strtotime($model->start_date))." - ".date('d-m-Y',strtotime($model->end_date))."</span>";
            }
            ],
            //'created_at:datetime',
            //'updated_at:datetime',

            ['class' => 'kartik\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php 
$customCss = <<< SCRIPT
    .route{
        font-size: 15px;
        font-weight: bold;
        padding-left:25px;
    }
    .company{
        font-size: 17px;
        font-weight: bold;
    }
SCRIPT;
$this->registerCss($customCss);
?>