<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => !empty($model->keywords) ? $model->keywords : substr($model->content, 0, 250)]);
$this->registerMetaTag(['name' => 'description', 'content' => !empty($model->description) ? $model->description : substr($model->description, 0, 250)]);
?>
<div class="row">
    <div class="col-xs-12 col-md-9 main">
        <div class="widget-question widget-article">
            <h3 class="title"><?= Html::encode($model->title); ?></h3>
            <div class="content mt-10">
                <div class="quote mb-20">
                    <?= $model->description; ?>
                </div>
                <div class="text-fmt">
                    <?= $model->content; ?>
                </div>
                <div class="post-opt mt-30">
                    <ul class="list-inline text-muted">
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <?=Yii::t('system', 'Published in');?> <?= Yii::$app->formatter->asDate($model->created_at) ?>
                        </li>
                        <li><?=Yii::t('system', 'Views');?> ( <?= $model->views ?> )</li>
                    </ul>
                </div>
            </div>


        </div>



    </div><!-- /.main -->


    <div class="col-xs-12 col-md-3 side">


    </div><!-- /.side -->
</div>