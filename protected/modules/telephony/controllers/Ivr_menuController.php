<?php
namespace application\modules\telephony\controllers;

/**
 * Class Ivr_menuController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class Ivr_menuController extends \CompanyController
{
    public $tab_menu = 'ivr_menu';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.IvrMenu.IndexAction',
            'create' => 'telephony.controllers.IvrMenu.CreateAction',
            'update' => 'telephony.controllers.IvrMenu.UpdateAction',
            'delete' => 'telephony.controllers.IvrMenu.DeleteAction',
        );
    }
}