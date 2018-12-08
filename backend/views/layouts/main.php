<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <link type="image/x-icon" href="../web/favicon.ico" rel="shortcut icon">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>'Linker',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } elseif (Yii::$app->user->identity->updated_at <= Yii::$app->user->identity->created_at){
        $menuItems[] = ['label' => '修改密码', 'url' => ['/site/update-pass']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout'])
            . Html::endForm()
            . '</li>';
    } else {
        $menuItems = [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ];
        if (Yii::$app->user->identity->username == 'admin') {
            $menuItems[] = ['label' => Yii::t('app', 'Create'), 'url' => ['/site/create']];
        }
        $menuItems[] = ['label' => Yii::t('app', 'Project Items'), 'url' => ['/project']];
        $menuItems[] = ['label' => Yii::t('app', 'Customers'), 'url' => ['/customer']];
        $menuItems[] = ['label' => Yii::t('app', 'Advisers'), 'url' => ['/adviser']];
        // $menuItems[] = ['label' => Yii::t('app', 'Trades'), 'url' => ['/trade']];
        if (in_array(Yii::$app->user->identity->username, ['admin'])) {
            $menuItems[] = ['label' => Yii::t('app', 'Finance'), 'url' => ['/project-adviser']];
        }
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(Yii::t('app', 'Logout') . '(' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout'])
            . Html::endForm()
            . '</li>';
        $menuItems[] = ['label' => '个人信息', 'url' => ['/site/profile']];
        $menuItems[] = ['label' => '修改密码', 'url' => ['/site/update-pass']];
        $menuItems[] = [
            'label' => Yii::t('app', 'Language'),
            'items' => [
                ['label' => '中文', 'url' => ['/site/language', 'lang' => 'zh_CN']],
                ['label' => 'English', 'url' => ['/site/language', 'lang' => 'en_US']],
            ]
        ];
    }
    echo Nav::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid content">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('app', 'Home'),
                'url' => Yii::$app->homeUrl
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; <?= Html::encode('Linker') ?> <?= date('Y') ?></p>

        <p class="pull-right hide"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
