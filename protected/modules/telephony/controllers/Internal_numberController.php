<?php
namespace application\modules\telephony\controllers;

/**
 * Class Internal_numberController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class Internal_numberController extends \CompanyController
{
    public $tab_menu = 'internal_number';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.InternalNumber.IndexAction',
        );
    }
}