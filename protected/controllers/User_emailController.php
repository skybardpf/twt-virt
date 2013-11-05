<?php
/**
 * Class User_emailController
 */
class User_emailController extends Controller
{
    public function actions()
    {
        return array(
            'create' => 'application.controllers.UserEmail.CreateAction',
            'update' => 'application.controllers.UserEmail.UpdateAction',
            'delete' => 'application.controllers.UserEmail.DeleteAction',
        );
    }
}