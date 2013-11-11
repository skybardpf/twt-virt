<?php
namespace application\modules\telephony\controllers;

/**
 * Class Call_logController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class Call_logController extends \CompanyController
{
    public $tab_menu = 'call_log';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.CallLog.IndexAction',
        );
    }
}