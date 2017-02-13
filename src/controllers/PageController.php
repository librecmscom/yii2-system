<?php

namespace yuncms\system\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yuncms\system\models\Page;

class PageController extends Controller
{
    /**
     * Display Page
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->updateCounters(['views' => 1]);
        return $this->render($model->view, [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $user = Page::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
        }
        return $user;
    }
}
