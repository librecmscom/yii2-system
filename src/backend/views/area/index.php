<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yuncms\admin\grid\TreeGrid;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/* @var \yii\web\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \yuncms\system\backend\models\AreaSearch $searchModel */

$this->title = Yii::t('system', 'Manage Area');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 area-index">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?= Toolbar::widget(['items' => [
                        [
                            'label' => Yii::t('system', 'Manage Area'),
                            'url' => ['index'],
                        ],
                        [
                            'label' => Yii::t('system', 'Create Area'),
                            'url' => ['create'],
                        ],
                    ]]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">

                </div>
            </div>
            <?php Pjax::begin(); ?>
            <?= TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',
                'parentColumnName' => 'parent',
                'parentRootValue' => null, //first parentId value
                'pluginOptions' => [
                    'initialState' => 'collapse',
                ],
                'columns' => [
                    'name',
                    'area_code',
                    'post_code',
                    [
                        'class' => 'yuncms\admin\grid\PositionColumn',
                        'attribute' => 'sort'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Operation'),
                        'template' => '{add} {view} {update} {delete}',
                        'buttons' => ['add' => function ($url, $model, $key) {
                            return Html::a('<span class="fa fa-plus"></span>',
                                Url::toRoute(['create', 'parent' => $model->id]), [
                                    'title' => Yii::t('system', 'Add subArea'),
                                    'aria-label' => Yii::t('system', 'Add subArea'),
                                    'data-pjax' => '0',
                                ]);
                        }]
                    ]
                ],
            ]); ?>
            <?php Pjax::end(); ?>
            <?php Box::end(); ?>
        </div>
    </div>
</div>