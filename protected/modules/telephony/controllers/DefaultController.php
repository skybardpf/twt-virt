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
            'sip' => 'telephony.controllers.Default.SipAction',
            'internal_number' => 'telephony.controllers.Default.InternalNumberAction',

            'bind_phones' => 'telephony.controllers.Default.BindPhonesAction',
        );
    }
}