<?php
use application\modules\domain\models as M;

/**
 * Редактирование страниц поддомена компании.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class PageAction extends CAction
{
    /**
     * @param integer $sid
     * @param string $kind
     * @throws CHttpException
     */
    public function run($sid, $kind)
    {
        if(!Yii::app()->user->checkAccess('viewSitePage')) {
            throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
        }

        if (!M\DomainPage::existsKind($kind)){
            throw new CHttpException(404, Yii::t('app', 'Неизвестный тип страницы'));
        }

        /**
         * @var application\modules\domain\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Страница сайта | ' . M\DomainPage::kindToString($kind);

        $model = M\Domain::model()->findByPk($sid);
        if ($model === null){
            throw new CHttpException(404, Yii::t('app', 'Не найден поддомен компании'));
        }

        $page = M\DomainPage::model()->find('domain_id=:domain_id AND kind=:kind', array(
            ':domain_id' => $model->primaryKey,
            ':kind' => $kind,
        ));
        if ($page === null){
            $page = new M\DomainPage();
            $page->kind = $kind;
            $page->domain_id = $model->primaryKey;
            $page->domain = $model;
        }

        if ($page->kind === M\DomainPage::KIND_CONTACTS){
            $page->setScenario('contacts');
        }

//        $class = str_replace('\\', '_', get_class($page));
        $data = Yii::app()->request->getPost(get_class($page));
        if ($data){
            if(!Yii::app()->user->checkAccess('updateSitePage')) {
                throw new CHttpException(403, Yii::t('app', 'Доступ запрещен'));
            }
            $page->attributes = $data;
            if ($page->validate()){
                $page->save(false);

                Yii::app()->user->setFlash('success', Yii::t('app', 'Данные успешно сохранены'));
                $controller->redirect(
                    $controller->createUrl(
                        'page',
                        array(
                            'cid' => $controller->company->primaryKey,
                            'sid' => $model->primaryKey,
                            'kind' => $page->kind,
                        )
                    )
                );
            }
        }

        $controller->render(
            'tabs',
            array(
                'content' => $controller->renderPartial(
                    'page_form',
                    array(
//                        'model' => $model,
                        'page' => $page,
                    ),
                    true
                ),
                'model' => $model,
                'active_tab' => 'page_'.$page->kind,
            )
        );
    }
}