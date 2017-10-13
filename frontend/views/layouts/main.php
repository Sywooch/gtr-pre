<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
  NavBar::begin([
        'brandLabel' => 'GiliTransfers',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar material-navbar material-navbar_primary navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        
        [
            'label' => 'Fast Boat',
            'url' => ['/content/fastboats'],
            'options'=>['class'=>'lis'],
            'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'Destination', 'url' => ['/content/destinations'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'Ports', 'url' => ['/content/ports'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'Article', 'url' => ['/content/articles'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'Cart ( '.Yii::$app->view->params['countCart'].' )', 'url' => ['/book/detail-data'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'About', 'url' => ['/site/about'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        [
        'label' => 'Contact', 'url' => ['/site/contact'],
        'options'=>['class'=>'lis'],
        'linkOptions'=>['class'=>'material-navbar__link'],
        ],
        
    ];
    if (Yii::$app->user->isGuest) {
      //  $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
      //  $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right material-navbar__nav'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    
 

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Gilitransfers.com <?= date('Y') ?></p>

        <p class="pull-right">
            <?= Html::a('Home', Yii::$app->homeUrl, ['class' => 'text-muted footer-link']); ?> 
            <br>
            <?= Html::a('About', '/site/about', ['class' => 'text-muted footer-link']); ?> 
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
