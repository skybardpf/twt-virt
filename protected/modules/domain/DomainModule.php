<?php
namespace application\modules\domain;

/**
 * Поддомены для определенной компании.
 *
 * Class DomainModule
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>`
 */
class DomainModule extends \CWebModule
{
//    public $baseAssets = null;

    protected function init()
	{
        parent::init();

		$this->setImport(array(
			'domain.models.*',
		));

        $this->layoutPath = \Yii::getPathOfAlias('domain.views.layouts');
        $this->layout = 'owner';

//        if ($this->baseAssets === null) {
//            $this->baseAssets = \Yii::app()->assetManager->publish(
//                \Yii::getPathOfAlias('domain.assets'),
//                false,
//                -1,
//                YII_DEBUG
//            );
//        }
	}
}
