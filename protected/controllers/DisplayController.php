<?php
use application\modules\domain\models as M;

class DisplayController extends Controller
{
    public $company_id;
    public $layout = '/layouts/main';
    public $controller_name = "sites";

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */

    public function accessRules()
    {
        return array();
    }

    public function actionIndex($site, $kind = null)
    {
    }

    public function actionTest()
    {
        $this->render('error', array());
    }

    /**
     * @param string $site
     * @param string $kind
     * @throws CHttpException
     */
    public function actionView($site, $kind = 'main')
    {
        /**
         * @var M\Domain $domain
         */
        $domain = M\Domain::model()->with('template')->find('domain=:domain', array(
            ':domain' => $site,
        ));
        if ($domain === null) {
            throw new CHttpException(404, 'Поддомен не найден');
        }
        if (!M\DomainPage::existsKind($kind)) {
            throw new CHttpException(404, 'Неизвестный вид страницы');
        }
        $page = M\DomainPage::model()->find('kind=:kind AND domain_id=:domain_id', array(
            ':kind' => $kind,
            ':domain_id' => $domain->primaryKey,
        ));
        if ($page === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        $menu = M\DomainPage::model()->findAll('domain_id=:domain_id AND is_show=1', array(
            ':domain_id' => $domain->primaryKey,
        ));

        $this->renderPartial(
            "//templates/" . $domain->template->name,
            array(
                'page' => $page,
                'menu' => $menu,
                'domain' => $domain,
            )
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}