<?php

use yii\helpers\Html;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $model yuncms\system\models\Language */

$this->title = Yii::t('system', 'Update Language') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Manage Language'), 'url' => ['index']];
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
                        'label' => Yii::t('system', 'Manage Language'),
                        'url' => ['index'],
                    ],
                    [
                        'label' => Yii::t('system', 'Create Language'),
                        'url' => ['create'],
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