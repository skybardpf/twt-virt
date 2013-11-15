<?php

class SitesController extends \CompanyController
{
    public $layout = '/layouts/owner';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'list' => 'application.controllers.Sites.ListAction',
            'page' => 'application.controllers.Sites.PageAction',
            'settings' => 'application.controllers.Sites.SettingsAction',
            'createform' => 'application.controllers.Sites.CreateFormAction',
            'delete' => 'application.controllers.Sites.DeleteAction',
        );
    }
}