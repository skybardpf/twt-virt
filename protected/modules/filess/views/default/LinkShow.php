<?php
/**
 * User: Forgon
 * Date: 04.02.13
 *
 * @var DefaultController $this
 */
?>
<textarea rows="3" cols="20" readonly="readonly" id="file_link_adress"><?=$this->createUrl('//files/public/show', array('key' => $model->key))?></textarea>
<button id="file_link_adress_copy">Скопировать в буфер обмена</button>
