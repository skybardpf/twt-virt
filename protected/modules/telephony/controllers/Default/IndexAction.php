<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    /**
     * @param integer $cid Идентификатор компании.
     */
    public function run($cid)
    {
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония';

        $controller->render(
            'index'
        );
    }
}