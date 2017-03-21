<?php

use yii\helpers\Html;
use yuncms\admin\widgets\Jarvis;

/* @var $this yii\web\View */
/* @var $model yuncms\system\models\Language */

$this->title = Yii::t('system', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Manage Language'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 url-rule-create">
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
