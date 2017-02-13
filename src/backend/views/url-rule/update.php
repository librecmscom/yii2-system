<?php

use yuncms\admin\helpers\Html;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $model common\models\UrlRule */

$this->title = Yii::t('backend/url-rule', 'Update Url Rule') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend/url-rule', 'Manage Url Rule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 url-rule-update">
            <?php Jarvis::begin([
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
                ]
            ]); ?>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <?php Jarvis::end(); ?>
        </article>
    </div>
</section>