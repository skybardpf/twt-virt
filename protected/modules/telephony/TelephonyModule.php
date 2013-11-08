<?php
namespace application\modules\telephony;

/**
 * Class TelephonyModule
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>`
 */
class TelephonyModule extends \CWebModule
{
    public $baseAssets = null;

    protected function init()
	{
        parent::init();

		$this->setImport(array(
			'telephony.models.*',
		));

        $this->layoutPath = \Yii::getPathOfAlias('telephony.views.layouts');
        $this->layout = 'owner';

        if ($this->baseAssets === null) {
            $this->baseAssets = \Yii::app()->assetManager->publish(
                \Yii::getPathOfAlias('telephony.assets'),
                false,
                -1,
                YII_DEBUG
            );
        }
	}
}
