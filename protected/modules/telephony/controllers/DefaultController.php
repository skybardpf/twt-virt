<?php
namespace application\modules\telephony\controllers;

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
            'index' => 'telephony.controllers.Default.IndexAction'
        );
    }

    /**
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array(
                    'index',
                ),
                'roles' => array(
                    \User::ROLE_COMPANY_ADMIN,
                    \User::ROLE_USER
                ),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }
}