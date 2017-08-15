<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;
use yuncms\system\models\Setting;

/**
 * @var yii\web\View $this
 * @var yuncms\system\backend\models\SettingSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('system', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 stream-index">
            <?= Alert::widget() ?>
            <?php Pjax::begin(); ?>
            <?php Box::begin([
                //'noPadding' => true,
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('system', 'Manage Settings'),
                            'url' => ['index'],
                        ],
                        [
                            'label' => Yii::t('system', 'Create {modelClass}', [
                                'modelClass' => Yii::t('system', 'Setting'),
                            ]),
                            'url' => ['create'],
                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">
                    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'options' => ['id' => 'gridview'],
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        'id',
                        //'type',
                        [
                            'attribute' => 'section',
                            'filter' => ArrayHelper::map(
                                Setting::find()->select('section')->distinct()->where(['<>', 'section', ''])->all(),
                                'section',
                                'section'
                            ),
                        ],
                        'key',
                        'value:ntext',
//                [
//                    'class' => '\pheme\grid\ToggleColumn',
//                    'attribute' => 'active',
//                    'filter' => [1 => Yii::t('yii', 'Yes'), 0 => Yii::t('yii', 'No')],
//                ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]
            ); ?>
            <?php Box::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>