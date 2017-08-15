<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yuncms\system\models\Setting;

/**
 * @var yii\web\View $this
 * @var Setting $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'section')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->checkbox(['value' => 1]) ?>

    <?=
    $form->field($model, 'type')->dropDownList(
        $model->getTypes()
    )->hint(Yii::t('system', 'Change at your own risk')) ?>

    <div class="form-group">
        <?=
        Html::submitButton(
            $model->isNewRecord ? Yii::t('system', 'Create') :
                Yii::t('system', 'Update'),
            [
                'class' => $model->isNewRecord ?
                    'btn btn-success' : 'btn btn-primary'
            ]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
