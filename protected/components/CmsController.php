<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CmsController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/admin';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array(
		array('label'=>'Компании', 'url'=>array('/admin_companies/index')),
		array('label'=>'Пользователи', 'url'=>array('/admin_users/index')),
		array('label'=>'Поддержка', 'url'=>array('/support/admin_support/index')),
	);
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function init()
	{
		Yii::app()->errorHandler->errorAction = 'admin/helper/error';
		parent::init();
	}

	public function filters()
	{
		return array_merge(array('accessControl'), parent::filters());
	}

	public function accessRules()
	{
		return array(
			array('deny', 'users'=>array('?'))
		);
	}

	/**
	 * The filter method for 'accessControl' filter.
	 * This filter is a wrapper of {@link CAccessControlFilter}.
	 * To use this filter, you must override {@link accessRules} method.
	 * @param CFilterChain $filterChain the filter chain that the filter is on.
	 */
	public function filterAccessControl($filterChain)
	{
		Yii::import('ext.AccessControlFilter');
		$filter=new AccessControlFilter;
		$filter->userComponentName = 'admin';
		$filter->setRules($this->accessRules());
		$filter->filter($filterChain);
	}
}