<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\components;

use Yii;
use yii\db\Exception;
use yii\web\UrlRuleInterface;
use yuncms\system\models\UrlRule;

/**
 * 自定义URL路由
 * @package common
 */
class SlugUrlRule extends \yii\web\UrlRule implements UrlRuleInterface
{
    /**
     * @var string the name of this rule. If not set, it will use [[pattern]] as the name.
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params = [])
    {
        $dbSlugName = false;
        try {
            $dbRoute = $this->getSlug($route, $params);
            if (is_object($dbRoute) && $dbRoute->hasAttribute('slug')) {
                $dbSlugName = $dbRoute->getAttribute('slug');
            }
        } catch (Exception $e) {

        }

        return $dbSlugName;
    }

    public function parseRequest($manager, $request)
    {
        try {
            $slug = '/' . $request->getPathInfo();
            $dbRoute = $this->getRoute($slug);
            if (is_object($dbRoute)) {
                if (($dbRoute->hasAttribute('redirect') && $dbRoute->getAttribute('redirect'))
                    || ($pos = strpos($dbRoute->route, '://')) !== false) {//检测是否转向
                    Yii::$app->response->redirect(
                        [$dbRoute->route],
                        $dbRoute->getAttribute('redirect_code')
                    );
                }
                $params = [];
                parse_str($dbRoute->getAttribute('params'), $params);
                return [
                    $dbRoute->getAttribute('route'),
                    $params
                ];
            }
        } catch (Exception $e) {

        }
        return false;
    }

    /**
     * 通过路由获取短网址
     * @param string $route slug
     * @param array $params URL参数
     * @return mixed|null|static
     */
    public function getSlug($route, $params = [])
    {
        $dbRoute = Yii::$app->cache->get([$route, $params]);
        if (YII_ENV_DEV || $dbRoute == false) {
            $dbRoute = UrlRule::getRoute($route, $params);
            Yii::$app->cache->set(
                [$route, $params],
                $dbRoute
            );
        }
        return $dbRoute;
    }

    /**
     * 通过短网址获取路由
     * @param string $slug URL 段
     * @return mixed|null|static
     */
    public function getRoute($slug)
    {
        $key = md5($slug);
        $dbRoute = Yii::$app->cache->get($key);
        if (YII_ENV_DEV || $dbRoute == false) {
            $dbRoute = UrlRule::getRouteBySlug($slug);
            Yii::$app->cache->set(
                $key,
                $dbRoute
            );
        }
        return $dbRoute;
    }
}