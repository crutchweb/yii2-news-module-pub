<?php

namespace gtd\modules\news\models;

use gtd\modules\news\models\News;

/**
 * Class NewsGroupForm
 * @package gtd\modules\news\models
 */
class NewsGroupForm extends NewsGroup {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		$parentRules = parent::rules();
		return $parentRules;
	}

    /**
     * @inheritdoc
     */
	public function attributeLabels() {
		$parentlabels = parent::attributeLabels();
		return $parentlabels;
	}

}
