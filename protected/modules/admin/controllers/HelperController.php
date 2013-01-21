<?php
class HelperController extends CmsController
{
	public function actions()
	{
		return array(
			// TinyMce
			'tinymce_compressor' => array(
				'class' => 'ext.tinymce.TinyMceCompressorAction',
				'settings' => array(
					'compress' => true,
					'disk_cache' => true,
				)
			),
			'tinymce_spellchecker' => array(
				'class' => 'ext.tinymce.TinyMceSpellcheckerAction',
			),
			// elFinder
			'elfinder_connector' => array(
				'class' => 'ext.elFinder.ElFinderConnectorAction',
				'settings' => array(
					'root' => Yii::getPathOfAlias('webroot.userfiles.uploads') ,
					'URL' => Yii::app()->baseUrl . '/userfiles/uploads/',
					'rootAlias' => 'Home',
					'mimeDetect' => 'none'
				)
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}