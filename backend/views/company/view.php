<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tcompanies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcompany-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'address',
            'email_bali:email',
            'email_gili:email',
            'phone',
            ['attribute'=>'logo_path',
            'format'=>'raw',
            'value'=>Html::img(['/company/logo','logo'=>$model->logo_path], ['class' => 'img-responsive']),
            ],
          //  'create_at',
            'update_at',
        ],
    ]) ?>

</div>
