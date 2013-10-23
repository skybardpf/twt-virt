<?php
/**
 * Class MailController
 */
class MailController extends Controller
{
	public $layout = '/layouts/owner';
	public $controller_name = "mail";

    /**
     * Загружаем в iframe roundcube. Управление почтой.
     */
    public function actionLayout()
	{
        $this->render('layout');
	}
}