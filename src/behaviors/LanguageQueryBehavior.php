<?php
/**
 * @link https://github.com/creocoder/yii2-taggable
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace yuncms\system\behaviors;

use yii\base\Behavior;
use yii\db\Expression;

/**
 * LanguageQueryBehavior
 *
 * @property \yii\db\ActiveQuery $owner
 */
class LanguageQueryBehavior extends Behavior
{
    /**
     * Gets entities by any languages.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function anyLanguageValues($values, $attribute = null)
    {
        /** @var \yii\db\ActiveRecord $model */
        $model = new $this->owner->modelClass();
        $languageClass = $model->getRelation($model->languageRelation)->modelClass;

        $this->owner
            ->innerJoinWith($model->languageRelation, false)
            ->andWhere([$languageClass::tableName() . '.' . ($attribute ?: $model->languageValueAttribute) => $model->filterLanguageValues($values)])
            ->addGroupBy(array_map(function ($pk) use ($model) {
                return $model->tableName() . '.' . $pk;
            }, $model->primaryKey()));

        return $this->owner;
    }

    /**
     * Gets entities by all languages.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function allLanguageValues($values, $attribute = null)
    {
        $model = new $this->owner->modelClass();

        return $this->anyLanguageValues($values, $attribute)->andHaving(new Expression('COUNT(*) = ' . count($model->filterLanguageValues($values))));
    }

    /**
     * Gets entities related by languages.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function relatedByLanguageValues($values, $attribute = null)
    {
        return $this->anyLanguageValues($values, $attribute)->addOrderBy(new Expression('COUNT(*) DESC'));
    }
}
