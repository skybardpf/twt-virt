<?php
/**
 * Class DeleteAction
 */
class DeleteAction extends CAction
{
    /**
     * @param integer $id
     * @throws CHttpException
     */
    public function run($id)
    {
        if (Yii::app()->request->isAjaxRequest){
            try {
                if(!Yii::app()->user->checkAccess('deleteSite')) {
                    throw new CException(Yii::t('app', 'Доступ запрещен'));
                }

                $cmd = Yii::app()->db->createCommand('
                    SELECT
                        s.id, cs.company_id, s.domain
                    FROM sites s
                    JOIN company2sites cs ON cs.site_id = s.id
                    JOIN user2company uc ON uc.company_id = cs.company_id
                    WHERE uc.user_id = :user_id AND s.id = :site_id
                ');
                $site = $cmd->queryRow(true, array(
                    ':user_id' => Yii::app()->user->id,
                    ':site_id' => $id,
                ));
                if (empty($site)){
                    throw new CException('Не найден сайт');
                }

                /**
                 * Удаляем саму площадку
                 */
                if (!Sites::model()->deleteByPk($site['id'])){
                    throw new CException('Не удалось удалить сайт.');
                }

                /**
                 * Удаляем файлы, связанные с сайтом.
                 */
                $dir = Yii::getPathOfAlias('webroot');

                if (file_exists($dir.'/upload/'.$site['id'].'_logo'))
                    unlink($dir.'/upload/'.$site['id'].'_logo');
                $files = array('page_main', 'page_about', 'page_contacts', 'page_partners', 'page_services');
                foreach ($files as $f){
                    if (file_exists($dir.'/upload/'.$site['id'].'_'.$f))
                        unlink($dir.'/upload/'.$site['id'].'_'.$f);

                    /**
                     * Удаляем связи с сайтом
                     */
                    $cmd = Yii::app()->db->createCommand('
                        DELETE FROM '.$f.' WHERE site_id=:site_id
                    ');
                    $cmd->execute(array(
                        ':site_id' => $site['id'],
                    ));
                }

                $cmd = Yii::app()->db->createCommand('
                    SELECT `file` FROM files WHERE site_id=:site_id
                ');
                $files = $cmd->queryAll(true, array(
                    ':site_id' => $site['id'],
                ));
                foreach ($files as $f){
                    if (file_exists($dir.$f['file']))
                        unlink($dir.$f['file']);
                }
                $cmd = Yii::app()->db->createCommand('
                    DELETE FROM files WHERE site_id=:site_id
                ');
                $cmd->execute(array(
                    ':site_id' => $site['id'],
                ));

                $cmd = Yii::app()->db->createCommand('
                    DELETE FROM company2sites WHERE site_id=:site_id AND company_id=:company_id
                ');
                $cmd->execute(array(
                    ':site_id' => $site['id'],
                    ':company_id' => $site['company_id'],
                ));

                /**
                 * Удаляем Email аккаунты
                 * @var UserEmail[] $emails
                 */
                $emails = UserEmail::model()->findAll('site_id=:site_id', array(
                    ':site_id' => $site['id'],
                ));
                UserEmail::model()->deleteAll('site_id=:site_id', array(
                    ':site_id' => $site['id'],
                ));
                foreach ($emails as $email){
                    \application\models\Mail\User::model()->deleteByPk(
                        $email->login_email.'@'.$site['domain'].'.'.Yii::app()->params->httpHostName
                    );
                }

                /**
                 * Удаляем запись на Devecot сервере
                 */
                $domain = application\models\Mail\Domain::model()->find(
                    'domain=:domain',
                    array(
                        ':domain' => $site['domain'].'.'.Yii::app()->params->httpHostName,
                    )
                );
                if ($domain !== null){
                    $domain->delete();
                }

                echo CJSON::encode(array(
                    'success' => true,
                ));

            } catch (CException $e){
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => $e->getMessage(),
                ));
            }
        }
    }
}