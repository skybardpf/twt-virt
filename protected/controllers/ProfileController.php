<?php
/**
 * Управление профайлом - личными данными пользователя.
 *
 * Class ProfileController
 */
class ProfileController extends Controller
{
    public $tab_menu = 'profile';

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'index' => 'application.controllers.Profile.IndexAction',
            'update' => 'application.controllers.Profile.UpdateAction',
            'change_pass' => 'application.controllers.Profile.ChangePassAction',
            'login_emails' => 'application.controllers.Profile.LoginEmailsAction',
        );
    }
}