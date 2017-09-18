<?php
use xutl\inspinia\ActiveForm;
use yii\helpers\Html;
use yuncms\system\models\Page;
use yuncms\ueditor\UEditor;

/* @var \yii\web\View $this */
/* @var yuncms\system\models\Page $model */
/* @var ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'enableAjaxValidation' => true, 'enableClientValidation' => false,]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'content')->widget(UEditor::className(), [

]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'view')->textInput(['maxlength' => true]) ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'views')->textInput() ?>
<div class="hr-line-dashed"></div>
<?= $form->field($model, 'status')->inline()->radioList([Page::STATUS_ACTIVE => Yii::t('app', 'Enable'), Page::STATUS_DELETE => Yii::t('app', 'Disable')]) ?>
<div class="hr-line-dashed"></div>

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>
</div>

<?php ActiveForm::end(); ?>

