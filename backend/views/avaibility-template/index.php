<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TAvaibilityTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Template List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tavaibility-template-index">

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

            'idCompany.name',
            'name',
            ['header'=>'Senin',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_senin != null && $model->senin != null) {
                    return date('H:i',strtotime($model->time_senin));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'Selasa',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_selasa != null && $model->selasa != null) {
                    return date('H:i',strtotime($model->time_selasa));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'Rabu',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_rabu != null && $model->rabu != null) {
                    return date('H:i',strtotime($model->time_rabu));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'kamis',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_kamis != null && $model->kamis != null) {
                    return date('H:i',strtotime($model->time_kamis));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'jumat',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_jumat != null && $model->jumat != null) {
                    return date('H:i',strtotime($model->time_jumat));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'sabtu',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_sabtu != null && $model->sabtu != null) {
                    return date('H:i',strtotime($model->time_sabtu));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
            ['header'=>'minggu',
            'format'=>'raw',
            'value'=>function($model){
                if ($model->time_minggu != null && $model->minggu == 0) {
                    return date('H:i',strtotime($model->time_minggu));
                }else{
                    return "<b class='text-danger'>Off</b>";
                }
                
            },
            ],
           // 'datetime',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update} {delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
