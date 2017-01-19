<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\behaviors;

use yii\base\Behavior;
use yii\db\Expression;

/**
 * CategoryQueryBehavior
 *
 * @property \yii\db\ActiveQuery $owner
 */
class CategoryQueryBehavior extends Behavior
{
    /**
     * Gets entities by any categories.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function anyCategoryValues($values, $attribute = null)
    {
        /** @var \yii\db\ActiveRecord $model */
        $model = new $this->owner->modelClass();
        $categoryClass = $model->getRelation($model->categoryRelation)->modelClass;

        $this->owner
            ->innerJoinWith($model->categoryRelation, false)
            ->andWhere([$categoryClass::tableName() . '.' . ($attribute ?: $model->categoryValueAttribute) => $model->filterCategoryValues($values)])
            ->addGroupBy(array_map(function ($pk) use ($model) {
                return $model->tableName() . '.' . $pk;
            }, $model->primaryKey()));

        return $this->owner;
    }

    /**
     * Gets entities by all categories.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function allCategoryValues($values, $attribute = null)
    {
        $model = new $this->owner->modelClass();

        return $this->anyCategoryValues($values, $attribute)->andHaving(new Expression('COUNT(*) = ' . count($model->filterCategoryValues($values))));
    }

    /**
     * Gets entities related by categories.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function relatedByCategoryValues($values, $attribute = null)
    {
        return $this->anyCategoryValues($values, $attribute)->addOrderBy(new Expression('COUNT(*) DESC'));
    }
}