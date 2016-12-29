<?php
namespace yuncms\system\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Language
 *
 * @property ActiveRecord $owner
 *
 * @package yuncms\system
 */
class LanguageBehavior extends Behavior
{
    /**
     * @var boolean whether to return languages as array instead of string
     */
    public $languageValuesAsArray = false;

    /**
     * @var string the languages relation name
     */
    public $languageRelation = 'languages';

    /**
     * @var string the languages model value attribute name
     */
    public $languageValueAttribute = 'name';

    /**
     * @var string[]
     */
    private $_languageValues;


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
     * Returns languages.
     * @param boolean|null $asArray
     * @return string|string[]
     */
    public function getLanguageValues($asArray = null)
    {
        if (!$this->owner->getIsNewRecord() && $this->_languageValues === null) {
            $this->_languageValues = [];

            /* @var ActiveRecord $language */
            foreach ($this->owner->{$this->languageRelation} as $language) {
                $this->_languageValues[] = $language->getAttribute($this->languageValueAttribute);
            }
        }

        if ($asArray === null) {
            $asArray = $this->languageValuesAsArray;
        }

        if ($asArray) {
            return $this->_languageValues === null ? [] : $this->_languageValues;
        } else {
            return $this->_languageValues === null ? '' : implode(', ', $this->_languageValues);
        }
    }

    /**
     * Sets languages.
     * @param string|string[] $values
     */
    public function setLanguageValues($values)
    {
        $this->_languageValues = $this->filterLanguageValues($values);
    }

    /**
     * Adds languages.
     * @param string|string[] $values
     */
    public function addLanguageValues($values)
    {
        $this->_languageValues = array_unique(array_merge($this->getLanguageValues(true), $this->filterLanguageValues($values)));
    }

    /**
     * Removes languages.
     * @param string|string[] $values
     */
    public function removeLanguageValues($values)
    {
        $this->_languageValues = array_diff($this->getLanguageValues(true), $this->filterLanguageValues($values));
    }

    /**
     * Removes all languages.
     */
    public function removeAllLanguageValues()
    {
        $this->_languageValues = [];
    }

    /**
     * Returns a value indicating whether languages exists.
     * @param string|string[] $values
     * @return boolean
     */
    public function hasLanguageValues($values)
    {
        $tagValues = $this->getLanguageValues(true);
        foreach ($this->filterLanguageValues($values) as $value) {
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
        if ($this->_languageValues === null) {
            return;
        }

        if (!$this->owner->getIsNewRecord()) {
            $this->beforeDelete();
        }

        $languageRelation = $this->owner->getRelation($this->languageRelation);
        $pivot = $languageRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $languageRelation->modelClass;
        $rows = [];

        foreach ($this->_languageValues as $value) {
            /* @var ActiveRecord $language */
            $language = $class::findOne([$this->languageValueAttribute => $value]);

            if ($language !== null && $language->save()) {
                $rows[] = [$this->owner->getPrimaryKey(), $language->getPrimaryKey()];
            }
        }

        if (!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($languageRelation->via->link), current($languageRelation->link)], $rows)
                ->execute();
        }
    }

    /**
     * 删除
     * @return void
     */
    public function beforeDelete()
    {
        $languageRelation = $this->owner->getRelation($this->languageRelation);
        $pivot = $languageRelation->via->from[0];

        $this->owner->getDb()
            ->createCommand()
            ->delete($pivot, [key($languageRelation->via->link) => $this->owner->getPrimaryKey()])
            ->execute();
    }

    /**
     * Filters languages.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterLanguageValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}
