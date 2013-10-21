<?php
/**
 * Class ListAction
 */
class ListAction extends CAction
{
    /**
     * @param integer $company_id
     * @throws CHttpException
     */
    public function run($company_id)
    {
        /**
         * @var SitesController $controller
         */
        $controller = $this->controller;

        if (empty($controller->company))
            throw new CHttpException(404, 'Не найдена компания');

        $sites = Sites::model()->getSites($company_id);
        $sites_num = Sites::model()->getSitesNumber($company_id);
        $sign['disabled'] = false;
        $sign['type'] = "link";
        if ($sites_num['have'] == $sites_num['max']) {
            $sign['disabled'] = true;
            $sign['type'] = "button";
            $sign['text'] = "Вы уже создали максимальное для этой компании количество сайтов. Чтобы создать новый сайт – требуется удалить один из уже существующих.";
        }

        $controller->render('sitelist',
            array(
                'sites' => $sites,
                'company_id' => $company_id,
                'sign' => $sign
            )
        );
    }
}