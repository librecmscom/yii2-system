<?php

use yuncms\admin\helpers\Html;
use yii\widgets\DetailView;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $model common\models\UrlRule */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/url-rule', 'Manage Url Rule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 url-rule-view">
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
                    [
                        'label' => Yii::t('backend/url-rule', 'Update Url Rule'),
                        'url' => ['/url-rule/update', 'id' => $model->id],
                        'options' => ['class' => 'btn btn-primary btn-sm']
                    ],
                    [
                        'label' => Yii::t('backend/url-rule', 'Delete Url Rule'),
                        'url' => ['/url-rule/delete', 'id' => $model->id],
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
                    'slug',
                    'route',
                    'params',
                    'redirect',
                    'redirect_code',
                    'status',
                ],
            ]) ?>
            <?php Jarvis::end(); ?>
        </article>
    </div>
</section>