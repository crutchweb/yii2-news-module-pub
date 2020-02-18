<?php

namespace gtd\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gtd\modules\news\models\NewsGroup;

/**
 * Class NewsGroupSearch
 * @package gtd\modules\news\models
 */
class NewsGroupSearch extends NewsGroup
{
    const COUNT = 10;

    public $id;
    public $name;
    public $is_active;
    public $url;
    public $timestamp;
    protected $timestamp_update;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'name',
                    'url',
                    'is_active',
                    'timestamp',
                    'timestamp_update',
                ],
                'safe'
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $label = parent::attributeLabels();

        return $label;
    }

    /**
     * Create DataProvider
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NewsGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $this::COUNT,
            ],
            'sort' => array(
                'defaultOrder' => ['id' => SORT_DESC],
            ),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (mb_strlen($this->id)) {
            $query->andWhere(['id' => $this->id,]);
        }
        if (mb_strlen($this->name)) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        if (mb_strlen($this->is_active)) {
            $query->andWhere(['is_active' => $this->is_active]);
        }
        if (mb_strlen($this->timestamp)) {
            $query->andFilterWhere(['like', 'timestamp', $this->timestamp]);
        }
        if (mb_strlen($this->timestamp_update)) {
            $query->andFilterWhere(['like', 'timestamp_update', $this->timestamp_update]);
        }

        return $dataProvider;
    }
}