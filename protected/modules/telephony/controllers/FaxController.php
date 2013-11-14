<?php
namespace application\modules\telephony\controllers;

/**
 * Class FaxController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class FaxController extends \CompanyController
{
    public $tab_menu = 'fax';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.Fax.IndexAction',
        );
    }
}