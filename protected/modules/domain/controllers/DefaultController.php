<?php
namespace application\modules\domain\controllers;

/**
 * Class DefaultController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class DefaultController extends \CompanyController
{
    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'domain.controllers.Default.IndexAction',
            'create' => 'domain.controllers.Default.CreateAction',
        );
    }
}