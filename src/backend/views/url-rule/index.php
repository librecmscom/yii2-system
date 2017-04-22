<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yuncms\system\models\UrlRule;
use yuncms\system\backend\models\UrlRuleSearch;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/* @var $this yii\web\View */
/* @var $searchModel yuncms\system\backend\models\UrlRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Manage Url Rule');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 url-rule-index">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('system', 'Manage Url Rule'),
                            'url' => ['index'],
                        ],
                        [
                            'label' => Yii::t('system', 'Create Url Rule'),
                            'url' => ['create'],
                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <?= GridView::widget([
                'layout' => "{items}\n{summary}\n{pager}",
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'slug',
                    'route',
                    'params',
                    'redirect',
                    [
                        'attribute' => 'redirect_code',
                        "filter" => UrlRuleSearch::dropDown("redirect_code"),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return UrlRuleSearch::dropDown("status", $model->status);
                        },
                        'label' => Yii::t('system', 'Status'),
                        "filter" => UrlRuleSearch::dropDown("status"),
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'header' => Yii::t('app', 'Operation'),],
                ],
            ]); ?>
            <?php Box::end(); ?>
        </div>
    </div>
</div>
