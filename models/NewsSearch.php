<?php

namespace gtd\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use gtd\modules\news\models\News;

/**
 * Class NewsSearch
 * @package gtd\modules\news\models
 */
class NewsSearch extends News
{
    const COUNT = 10;

    public $id;
    public $name;
    public $url;
    public $is_active;
    public $text_announcement;
    public $timestamp;
    public $timestamp_update;
    public $timestamp_start;

    /**
     * @return array
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
                    'text_announcement',
                    'timestamp',
                    'timestamp_update',
                    'timestamp_start',
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
        $query = News::find();

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
        if (mb_strlen($this->is_active)) {
            $query->andWhere(['is_active' => $this->is_active]);
        }
        if (mb_strlen($this->timestamp)) {
            $query->andFilterWhere(['like', 'timestamp', $this->timestamp]);
        }
        if (mb_strlen($this->timestamp_update)) {
            $query->andFilterWhere(['like', 'timestamp_update', $this->timestamp_update]);
        }
        if (mb_strlen($this->timestamp_start)) {
            $query->andFilterWhere(['like', 'timestamp_start', $this->timestamp_start]);
        }
        if (mb_strlen($this->url)) {
            $query->andFilterWhere(['like', 'url', $this->url]);
        }
        if (mb_strlen($this->name)) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        if (mb_strlen($this->text_announcement)) {
            $query->andFilterWhere(['like', 'text_announcement', $this->text_announcement]);
        }

        return $dataProvider;
    }
}