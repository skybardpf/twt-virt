<?php
/**
 * Контроллер, который работает с указанной компанией.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class CompanyController extends Controller
{
    public $layout = null;

	/**
     * @var Company $company
     */
	public $company = NULL;

    /**
     * @param CAction $action
     * @return bool
     * @throws CHttpException
     */
    protected function beforeAction($action)
	{
        $cid = Yii::app()->request->getParam('cid');
        if ($cid === null){
            throw new CHttpException(403, 'Не указана компания');
        }
        $this->company = Company::model()->with('user2company')->findByPk($cid, 'user2company.user_id=:user_id', array(
            ':user_id' => Yii::app()->user->id,
        ));
        if ($this->company === null){
            throw new CHttpException(403, 'Не найдена, указанная компания');
        }

		return parent::beforeAction($action);
	}

    /**
     * @param $model
     * @return mixed
     */
    public function getClassNameWithNamespace($model)
    {
        return str_replace('\\', '_', get_class($model));
    }
}