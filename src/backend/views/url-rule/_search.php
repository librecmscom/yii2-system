<?php

use yuncms\admin\helpers\Html;
use xutl\inspinia\ActiveForm;

/* @var $this yii\web\View */
/* @var $model yuncms\system\backend\models\UrlRuleSearch */
/* @var $form ActiveForm */
?>

<div class="url-rule-search  pull-right">

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

    <?= $form->field($model, 'slug', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('slug'),
        ],
    ]) ?>

    <?= $form->field($model, 'route', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel('route'),
        ],
    ]) ?>

<!--    --><?//= $form->field($model, 'params', [
//        'inputOptions' => [
//            'placeholder' => $model->getAttributeLabel('params'),
//        ],
//    ]) ?>
<!---->
<!--    --><?//= $form->field($model, 'redirect', [
//        'inputOptions' => [
//            'placeholder' => $model->getAttributeLabel('redirect'),
//        ],
//    ]) ?>

    <?php // echo $form->field($model, 'redirect_code') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
