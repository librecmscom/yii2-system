<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use xutl\inspinia\Box;
use xutl\inspinia\Toolbar;
use xutl\inspinia\Alert;

/**
 * @var yii\web\View $this
 * @var yuncms\system\models\Setting $model
 */

$this->title = $model->section . '.' . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 stream-view">
            <?= Alert::widget() ?>
            <?php Box::begin([
                'header' => Html::encode($this->title),
            ]); ?>
            <div class="row">
                <div class="col-sm-4 m-b-xs">
                    <?php
                    $items = [
                        [
                            'label' => Yii::t('system', 'Manage Settings'),
                            'url' => ['index'],
                        ],
                        [
                            'label' => Yii::t('system', 'Update Settings'),
                            'url' => ['update', 'id' => $model->id],
                            'options' => ['class' => 'btn btn-primary btn-sm']
                        ],
                        [
                            'label' => Yii::t('system', 'Delete'),
                            'url' => ['delete', 'id' => $model->id],
                            'options' => [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => Yii::t('system', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]
                        ],
                    ];
                    ?>
                    <?= Toolbar::widget(['items' => $items]); ?>
                </div>
                <div class="col-sm-8 m-b-xs">

                </div>
            </div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'type',
                    'section',
                    'active:boolean',
                    'key',
                    'value:ntext',
                    'created:datetime',
                    'modified:datetime',
                ],
            ]) ?>
            <?php Box::end(); ?>

        </div>
    </div>
</div>
