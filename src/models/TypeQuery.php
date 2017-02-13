<?php

namespace yuncms\system\models;

/**
 * This is the ActiveQuery class for [[Type]].
 *
 * @see Type
 */
class TypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Type[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Type|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
