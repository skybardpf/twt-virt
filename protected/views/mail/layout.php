<?php
/**
 * @var UserEmail $model
 * @var MailController $this
 */

//$url = Yii::app()->params->urlWebMail . '/rclogin.php?l=' . 'postmaster' . '&p=' . strtr(base64_encode(addslashes(gzcompress(serialize('ENp71xxA'), 9))), '+/=', '-_,');
//$url = Yii::app()->params->urlWebMail . '/rclogin.php?l=' . $model->getFullDomain() . '&p=' . strtr(base64_encode(addslashes(gzcompress(serialize($model->password), 9))), '+/=', '-_,');

$url = 'https://144.76.221.53/mail/twt/login_submit.php?l=' . 'postmaster' . '&p=' . strtr(base64_encode(addslashes(gzcompress(serialize('ENp71xxA'), 9))), '+/=', '-_,');
?>
<iframe src="<?= $url; ?>" width="100%" height="800px" allowTransparency="true" frameborder="0" scrolling="no">

</iframe>