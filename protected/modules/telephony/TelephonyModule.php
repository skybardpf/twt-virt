<?php
namespace application\modules\telephony;

/**
 * Class TelephonyModule
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>`
 */
class TelephonyModule extends \CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'telephony.models.*',
		));

        $this->layoutPath = \Yii::getPathOfAlias('telephony.views.layouts');
        $this->layout = 'owner';
	}
}
