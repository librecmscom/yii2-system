<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yuncms\admin\widgets\Jarvis;

/* @var \yii\web\View $this */
/* @var \yuncms\admin\models\AdminMenu $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Manage Category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php Jarvis::begin([
                'noPadding' => true,
                'editbutton' => false,
                'deletebutton' => false,
                'header' => Html::encode($this->title),
                'bodyToolbarActions' => [
                    [
                        'label' => Yii::t('system', 'Manage Category'),
                        'url' => ['/system/category/index'],
                    ],
                    [
                        'label' => Yii::t('system', 'Create Category'),
                        'url' => ['/system/category/create'],
                    ],
                    [
                        'label' => Yii::t('system', 'Update Category'),
                        'url' => ['/system/category/update', 'id' => $model->id],
                    ],
                    [
                        'label' => Yii::t('system', 'Delete Category'),
                        'url' => ['/system/category/delete', 'id' => $model->id],
                        'options' => [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]
                    ],
                ]
            ]); ?>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'categoryParent.name:text:Parent',
                    'name',
                    'slug',
                    'sort',
                ],
            ])
            ?>
            <?php Jarvis::end(); ?>
        </article>
    </div>
</section>
