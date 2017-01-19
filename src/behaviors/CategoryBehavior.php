<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Category
 *
 * @property ActiveRecord $owner
 *
 * @package yuncms\system
 */
class CategoryBehavior extends Behavior
{
    /**
     * @var boolean whether to return categories as array instead of string
     */
    public $categoryValuesAsArray = false;

    /**
     * @var string the categories relation name
     */
    public $categoryRelation = 'categories';

    /**
     * @var string the categories model value attribute name
     */
    public $categoryValueAttribute = 'name';

    /**
     * @var string[]
     */
    private $_categoryValues;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Returns categories.
     * @param boolean|null $asArray
     * @return string|string[]
     */
    public function getCategoryValues($asArray = null)
    {
        if (!$this->owner->getIsNewRecord() && $this->_categoryValues === null) {
            $this->_categoryValues = [];

            /* @var ActiveRecord $category */
            foreach ($this->owner->{$this->categoryRelation} as $category) {
                $this->_categoryValues[] = $category->getAttribute($this->categoryValueAttribute);
            }
        }

        if ($asArray === null) {
            $asArray = $this->categoryValuesAsArray;
        }

        if ($asArray) {
            return $this->_categoryValues === null ? [] : $this->_categoryValues;
        } else {
            return $this->_categoryValues === null ? '' : implode(', ', $this->_categoryValues);
        }
    }

    /**
     * Sets categories.
     * @param string|string[] $values
     */
    public function setCategoryValues($values)
    {
        $this->_categoryValues = $this->filterCategoryValues($values);
    }

    /**
     * Adds categories.
     * @param string|string[] $values
     */
    public function addCategoryValues($values)
    {
        $this->_categoryValues = array_unique(array_merge($this->getCategoryValues(true), $this->filterCategoryValues($values)));
    }

    /**
     * Removes categories.
     * @param string|string[] $values
     */
    public function removeCategoryValues($values)
    {
        $this->_categoryValues = array_diff($this->getCategoryValues(true), $this->filterCategoryValues($values));
    }

    /**
     * Removes all categories.
     */
    public function removeAllCategoryValues()
    {
        $this->_categoryValues = [];
    }

    /**
     * Returns a value indicating whether categories exists.
     * @param string|string[] $values
     * @return boolean
     */
    public function hasCategoryValues($values)
    {
        $tagValues = $this->getCategoryValues(true);
        foreach ($this->filterCategoryValues($values) as $value) {
            if (!in_array($value, $tagValues)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 保存
     * @return void
     */
    public function afterSave()
    {
        if ($this->_categoryValues === null) {
            return;
        }

        if (!$this->owner->getIsNewRecord()) {
            $this->beforeDelete();
        }

        $categoryRelation = $this->owner->getRelation($this->categoryRelation);
        $pivot = $categoryRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $categoryRelation->modelClass;
        $rows = [];

        foreach ($this->_categoryValues as $value) {
            /* @var ActiveRecord $category */
            $category = $class::findOne([$this->categoryValueAttribute => $value]);

            if ($category !== null && $category->save()) {
                $rows[] = [$this->owner->getPrimaryKey(), $category->getPrimaryKey()];
            }
        }

        if (!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($categoryRelation->via->link), current($categoryRelation->link)], $rows)
                ->execute();
        }
    }

    /**
     * 删除
     * @return void
     */
    public function beforeDelete()
    {
        $categoryRelation = $this->owner->getRelation($this->categoryRelation);
        $pivot = $categoryRelation->via->from[0];

        $this->owner->getDb()
            ->createCommand()
            ->delete($pivot, [key($categoryRelation->via->link) => $this->owner->getPrimaryKey()])
            ->execute();
    }

    /**
     * Filters categories.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterCategoryValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}