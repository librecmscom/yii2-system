<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system\api\models;

use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * Class Country
 * @package yuncms\system\api\models
 */
class Country extends \yuncms\system\models\Country implements Linkable
{
    /**
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['/system/country/view', 'id' => $this->id], true),
        ];
    }
}