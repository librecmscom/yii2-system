<?php
use yii\helpers\Html;
use xutl\inspinia\ActiveForm;
use yuncms\system\models\UrlRule;

/* @var \yii\web\View $this */
/* @var yuncms\system\models\UrlRule $model */
/* @var ActiveForm $form */
?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>

<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'params')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'redirect')->inline(true)->radioList(['0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'redirect_code')->inline(true)->radioList(['301' => '301', '302' => '302']) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'status')->inline(true)->radioList([UrlRule::STATUS_ACTIVE => Yii::t('app', 'Enable'), UrlRule::STATUS_PASSIVE => Yii::t('app', 'Disable')]) ?>
<div class="hr-line-dashed"></div>

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>
</div>


<?php ActiveForm::end(); ?>

