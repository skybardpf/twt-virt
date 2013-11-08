<?php
namespace application\modules\telephony\controllers;

/**
 * Class Ivr_commandController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class Ivr_commandController extends \CompanyController
{
    public $tab_menu = 'ivr_command';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.IvrCommand.IndexAction',
        );
    }
}