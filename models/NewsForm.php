<?php

namespace gtd\modules\news\models;

use gtd\modules\news\models\News;

/**
 * Class NewsForm
 * @package gtd\modules\news\models
 */
class NewsForm extends News {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		$parentRules = parent::rules();
		return $parentRules;
	}

	public function attributeLabels() {
		$parentlabels = parent::attributeLabels();
		return $parentlabels;
	}

}
