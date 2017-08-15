<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yuncms\system\models\Setting $model
 */

$this->title = Yii::t('system', 'Update {modelClass}: ', [
        'modelClass' => Yii::t('system', 'Setting'),
    ]) . ' ' . $model->section . '.' . $model->key;

$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update');

?>
<div class="setting-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>
</div>
