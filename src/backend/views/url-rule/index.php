<?php

use yuncms\admin\helpers\Html;
use yuncms\admin\widgets\Jarvis;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\UrlRule;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UrlRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend/url-rule', 'Manage Url Rule');
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 url-rule-index">
            <?php Pjax::begin(); ?>                
            <?php Jarvis::begin([
                'noPadding' => true,
                'editbutton' => false,
                'deletebutton' => false,
                'header' => Html::encode($this->title),
                'bodyToolbarActions' => [
                    [
                        'label' => Yii::t('backend/url-rule', 'Manage Url Rule'),
                        'url' => ['/url-rule/index'],
                    ],
                    [
                        'label' => Yii::t('backend/url-rule', 'Create Url Rule'),
                        'url' => ['/url-rule/create'],
                    ],
                ]
            ]); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'slug',
                    'route',
                    'params',
                    'redirect',
                    'redirect_code',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->status == UrlRule::STATUS_ACTIVE ? Yii::t('backend/url-rule', 'Active') : Yii::t('backend/url-rule', 'Disable');
                        },
                        'label' => Yii::t('app', 'Status'),
                    ],
                    ['class' => 'yii\grid\ActionColumn','header' => Yii::t('app', 'Operation'),],
                ],
            ]); ?>
            <?php Jarvis::end(); ?>
            <?php Pjax::end(); ?>
        </article>
    </div>
</section>
