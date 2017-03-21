<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $model yuncms\system\models\Language */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Manage Language'), 'url' => ['index']];
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
                        'label' => Yii::t('system', 'Manage Language'),
                        'url' => ['index'],
                    ],
                    [
                        'label' => Yii::t('system', 'Create Language'),
                        'url' => ['create'],
                    ],
                    [
                        'label' => Yii::t('system', 'Update Language'),
                        'url' => ['update', 'id' => $model->id],
                        'options' => ['class' => 'btn btn-primary btn-sm']
                    ],
                    [
                        'label' => Yii::t('system', 'Delete Language'),
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
                    'name',
                    'name',
                    'iso_639_1',
                    'iso_639_2',
                    'iso_639_3',
                ],
            ]) ?>
            <?php Jarvis::end(); ?>
        </article>
    </div>
</section>