<?php

namespace yuncms\system\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yuncms\system\models\UrlRule;

/**
 * UrlRuleSearch represents the model behind the search form about `common\models\UrlRule`.
 */
class UrlRuleSearch extends UrlRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'redirect', 'redirect_code', 'status'], 'integer'],
            [['slug', 'route', 'params'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UrlRule::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'redirect' => $this->redirect,
            'redirect_code' => $this->redirect_code,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }

    /**
     * 下拉筛选
     * @param string $column
     * @param null|string $value
     * @return bool|mixed
     */
    public static function dropDown($column, $value = null)
    {
        $dropDownList = [
            "status" => [
                UrlRule::STATUS_ACTIVE => Yii::t('system', 'Active'),
                UrlRule::STATUS_PASSIVE => Yii::t('system', 'Disable'),
            ],
            "redirect_code" => [
                "301" => "301",
                "302" => "302",
            ],
        ];
        //根据具体值显示对应的值
        if ($value !== null) {
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column][$value] : false;
        } else {//返回关联数组，用户下拉的filter实现
            return array_key_exists($column, $dropDownList) ? $dropDownList[$column] : false;
        }
    }
}
