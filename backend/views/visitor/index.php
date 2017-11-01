<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\TVisitor;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TVisitorearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tvisitor');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tvisitor-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            'header'=>'Ip Address',
            'attribute'=>'ip',
            'value'=>function($model){
                return $model->ip;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->asArray()->all(), 'ip', 'ip'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Ip...'],
            ],
            [
            'header'=>'Country',
            'width'=>'auto',
            'attribute'=>'id_country',
            'value'=>function($model){
                return $model->idCountry->name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->joinWith('idCountry')->asArray()->all(), 'id_country', 'idCountry.name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Country'],
            ],
            [
            'header'=>'Region',
            'width'=>'auto',
            'attribute'=>'region',
            'value'=>function($model){
                return $model->region;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->joinWith('idCountry')->asArray()->all(), 'region', 'region'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Region...'],
            ],
            [
            'header'=>'City',
            'width'=>'auto',
            'attribute'=>'city',
            'value'=>function($model){
                return $model->city;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->joinWith('idCountry')->asArray()->all(), 'city', 'city'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any City...'],
            ],
            [
            'header'=>'TimeZone',
            'width'=>'auto',
            'attribute'=>'id_timezone',
            'value'=>function($model){
                return $model->idTimezone->timezone;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->joinWith('idTimezone')->asArray()->all(), 'id_timezone', 'idTimezone.timezone'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any City...'],
            ],
            [
            'header'=>'Url',
            'width'=>'auto',
            'format'=>'raw',
            'attribute'=>'url',
            'value'=>function($model){
                return Html::a($model->url,Yii::$app->urlFrontend->baseUrl.$model->url, ['class' => 'text-info','target'=>'_blank']);
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->select('url')->groupBy('url')->asArray()->all(), 'url', 'url'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Page...'],
            ],
            [
            'header'=>'Coordinate',
            'width'=>'auto',
            'format'=>'raw',
            'value'=>function($model){
                return Html::a($model->latitude."/".$model->longitude,Yii::$app->urlMaps->baseUrl."/".$model->latitude.",".$model->longitude, ['class' => 'text-info','target'=>'_blank']);
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(TVisitor::find()->select('url')->groupBy('url')->asArray()->all(), 'url', 'url'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,'tags'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any Page...'],
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'latitude',
            'longitude',
            'user_agent:ntext',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
