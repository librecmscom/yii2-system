<?php

use yii\helpers\Html;
use xutl\inspinia\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yuncms\system\models\PageSearch */
/* @var $form ActiveForm */
?>

<div class="page-search pull-right">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('id'),
        ],
    ]) ?>

    <?= $form->field($model, 'title', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('title'),
        ],
    ]) ?>

<!--    --><?//= $form->field($model, 'keywords', [
//        'inputOptions' => [
//            'placeholder' => $model->getAttributeLabel('id'),
//        ],
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'description', [
//        'inputOptions' => [
//            'placeholder' => $model->getAttributeLabel('id'),
//        ],
//    ]) ?>

    <?= $form->field($model, 'route', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('route'),
        ],
    ]) ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
