<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yuncms\system\models\Setting $model
 */

$this->title = Yii::t(
    'system',
    'Create {modelClass}',
    [
        'modelClass' => Yii::t('system', 'Setting'),
    ]
);
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>
