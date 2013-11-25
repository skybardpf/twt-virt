<?php
use application\modules\domain\models as M;

class DisplayController extends Controller
{
    public function accessRules()
    {
        return array();
    }

    /**
     * @param string $site
     * @param string $kind
     * @throws CHttpException
     */
    public function actionView($site, $kind = 'main')
    {
        if (!M\DomainPage::existsKind($kind)) {
            $kind = 'main';
        }
        /**
         * @var M\Domain $domain
         */
        $domain = M\Domain::model()->with('template')->find('domain=:domain', array(
            ':domain' => $site,
        ));
        if ($domain === null) {
            throw new CHttpException(404, 'Поддомен не найден');
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
}