<?php
namespace application\modules\telephony\controllers;

/**
 * Class DefaultController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class DefaultController extends \CompanyController
{
    public $tab_menu = 'info';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.Default.IndexAction',
            'call_logs' => 'telephony.controllers.Default.CallLogsAction',
            'sip' => 'telephony.controllers.Default.SipAction',
            'fax' => 'telephony.controllers.Default.FaxAction',
            'internal_numbers' => 'telephony.controllers.Default.InternalNumbersAction',

            'ivr' => 'telephony.controllers.Default.IvrAction',
            'bind_phones' => 'telephony.controllers.Default.BindPhonesAction',
        );
    }
}