<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yuncms\system\models\UrlRule;

/* @var \yii\web\View $this */
/* @var common\models\UrlRule $model */
/* @var ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>
<fieldset>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso_639_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso_639_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iso_639_3')->textInput(['maxlength' => true]) ?>

   </fieldset>
<div class="form-actions">
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

