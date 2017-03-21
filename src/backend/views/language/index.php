<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yuncms\system\models\UrlRule;
use yuncms\system\backend\models\UrlRuleSearch;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $searchModel yuncms\system\backend\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Manage Language');
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
                        'label' => Yii::t('system', 'Manage Language'),
                        'url' => ['index'],
                    ],
                    [
                        'label' => Yii::t('system', 'Create Language'),
                        'url' => ['create'],
                    ],
                ]
            ]); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'iso_639_1',
                    'iso_639_2',
                    'iso_639_3',
                    ['class' => 'yii\grid\ActionColumn', 'header' => Yii::t('app', 'Operation'),],
                ],
            ]); ?>
            <?php Jarvis::end(); ?>
            <?php Pjax::end(); ?>
        </article>
    </div>
</section>
