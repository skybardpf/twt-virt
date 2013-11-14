<?php
namespace application\modules\telephony\controllers;

/**
 * Class Bind_phonesController
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class Bind_phonesController extends \CompanyController
{
    public $tab_menu = 'bind_phones';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'telephony.controllers.BindPhones.IndexAction',
        );
    }
}