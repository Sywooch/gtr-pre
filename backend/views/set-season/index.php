<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
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
                'groupFooter'       =>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns'=>[[0,2]], // columns to merge in summary
                        'content'=>[             // content to show in each summary cell
                           // 0=> $model->idPayment->name." - ".$model->idPayment->phone,
                           // 4=>GridView::F_AVG,
                           // 5=>GridView::F_SUM,
                           // 6=>GridView::F_SUM,
                        ],
                        'contentFormats'=>[      // content reformatting for each summary cell
                          //  4=>['format'=>'number', 'decimals'=>2],
                           // 5=>['format'=>'number', 'decimals'=>0],
                           // 6=>['format'=>'number', 'decimals'=>2],
                        ],
                        'contentOptions'=>[      // content html attributes for each summary cell
                           // 0=>['style'=>'font-variant:small-caps'],
                           // 4=>['style'=>'text-align:right'],
                            //5=>['style'=>'text-align:right'],
                            //6=>['style'=>'text-align:right'],
                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'success','style'=>'font-weight:bold;']
                    ];
            }
            ],
            [
            'attribute'=>'departure',
            'format'=>'raw' ,
            'width'=>'100px',
            'vAlign'=>'top',
            'value'=>function ($model, $key, $index, $widget) { 
                return "<span class='route'>".$model->idRoute->departureHarbor->name."</span> ";
            },
            /*'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category'],*/
            'group'=>true,  // enable grouping
            'groupedRow'        =>true,
            'subGroupOf'=>1, // supplier column index is the parent group,
            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[2, 3]], // columns to merge in summary
                    'content'=>[              // content to show in each summary cell
                     //   2=>'Summary By Route(' . $model->idRoute->departureHarbor->name." -> ".$model->idRoute->arrivalHarbor->name . ')',
                       // 4=>GridView::F_AVG,
                        //5=>GridView::F_SUM,
                        //6=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                       // 4=>['format'=>'number', 'decimals'=>2],
                       // 5=>['format'=>'number', 'decimals'=>0],
                        //6=>['format'=>'number', 'decimals'=>2],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                       // 4=>['style'=>'text-align:right'],
                        //5=>['style'=>'text-align:center'],
                       // 6=>['style'=>'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options'=>['class'=>'success','style'=>'font-weight:bold;']
                ];
            },
            ],
            
            'idSeasonType.season',
            [
            'header'=>'<span class="fa fa-code-fork"> Route</span>',

            'format'=>'raw',
            'value'=>function($model){
                return $model->idRoute->departureHarbor->name."<span class='fa fa-arrow-right'></span>".$model->idRoute->arrivalHarbor->name;
            }
            ],
            [
            'header'=>'Price<br><span class="fa fa-user">Adult</span>/<span class="fa fa-child">Child</span>',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($model){
                return "<br><span class='fa fa-user'> Rp </span> ".number_format($model->adult_price,0)." /<span class='fa fa-child'>  Rp </span> ".number_format($model->child_price,0);
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