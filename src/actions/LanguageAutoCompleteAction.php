<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\actions;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yuncms\system\models\Language;

/**
 * Class AutoCompleteAction
 *
 * ```php
 * public function actions()
 * {
 *      return [
 *          'auto-complete' => [
 *              'class' => 'yuncms\tag\actions\AutoCompleteAction',
 *              'clientIdGetParamName'=>'query',
 *              'clientLimitGetParamName'=>'limit',
 *          ]
 *      ];
 * }
 * ```
 *
 * @package Leaps\Tag
 */
class LanguageAutoCompleteAction extends Action
{

    public $clientIdGetParamName = 'query';

    public $clientLimitGetParamName = 'limit';

    /**
     * @return array
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Language::find();
        $rows = $query->select(['id', 'name', 'name as text'])
            ->where(['like', 'name', Yii::$app->request->get($this->clientIdGetParamName)])
            ->orderBy(['name' => SORT_ASC])
            ->limit(Yii::$app->request->get($this->clientLimitGetParamName, 100))
            ->asArray()
            ->all();
        return $rows;
    }
}