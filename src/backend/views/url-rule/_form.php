<?php
use yii\bootstrap\ActiveForm;
use yuncms\admin\helpers\Html;
use common\models\UrlRule;

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
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'params')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'redirect')->inline(true)->radioList(['0' => Yii::t('app', 'No'), '1' => Yii::t('app', 'Yes')]) ?>

    <?= $form->field($model, 'redirect_code')->inline(true)->radioList(['301' => '301', '302' => '302']) ?>

    <?= $form->field($model, 'status')->inline(true)->radioList([UrlRule::STATUS_ACTIVE => Yii::t('app', 'Enable'), UrlRule::STATUS_PASSIVE => Yii::t('app', 'Disable')]) ?>
</fieldset>
<div class="form-actions">
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

