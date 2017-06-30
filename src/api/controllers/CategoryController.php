<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system\api\controllers;

use Yii;
use yuncms\oauth2\ActiveController;

/**
 * Class CategoryController
 * @package yuncms\live\controllers
 */
class CategoryController extends ActiveController
{
    public $modelClass = 'yuncms\system\api\models\Category';

    /**
     * @return array 重置允许的动作
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['update']);
        return $actions;
    }
}