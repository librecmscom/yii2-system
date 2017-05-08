<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace api\models;

use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * Class Category
 * @package api\models
 */
class Category extends \yuncms\system\models\Category implements Linkable
{
    /**
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['category/view', 'id' => $this->id], true),
        ];
    }
}