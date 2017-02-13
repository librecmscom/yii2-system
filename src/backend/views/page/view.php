<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yuncms\admin\widgets\Jarvis;
use yuncms\system\models\Page;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Manage Page'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-view">
            <?php Jarvis::begin([
                'noPadding' => true,
                'editbutton' => false,
                'deletebutton' => false,
                'header' => Html::encode($this->title),
                'bodyToolbarActions' => [
                    [
                        'label' => Yii::t('system', 'Manage Page'),
                        'url' => ['index'],
                    ],
                    [
                        'label' => Yii::t('system', 'Create Page'),
                        'url' => ['create'],
                    ],
                    [
                        'label' => Yii::t('system', 'Update Page'),
                        'url' => ['update', 'id' => $model->id],
                        'options' => ['class' => 'btn btn-primary btn-sm']
                    ],
                    [
                        'label' => Yii::t('system', 'Delete Page'),
                        'url' => ['delete', 'id' => $model->id],
                        'options' => [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]
                    ],
                ]
            ]); ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'keywords',
                    'description',
                    'route',
                    'content:html',
                    'view',
                    'views',
                    [
                        'value' => $model->status == Page::STATUS_ACTIVE ? Yii::t('app', 'Active') : Yii::t('app', 'Disable'),
                        'label' => Yii::t('app', 'Status'),
                    ],
                    'user_id',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
            <?php Jarvis::end(); ?>
        </article>
    </div>
</section>