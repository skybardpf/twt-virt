<?php
/**
 * @var $this SitesController
 * @var $companies Company[]
 */

Yii::import('bootstrap.widgets.TbButton');

$this->pageTitle=Yii::app()->name;

Yii::app()->clientScript->registerScriptFile($this->asset_static.'/js/sites/list.js');
?>

<h1>Список сайтов</h1>

<table class="table table-striped table-hover table-condensed">
	<tr>
		<th>Название сайта</th>
		<th>Домен</th>
		<th>Шаблон</th>
		<th>Действие</th>
	</tr>
	<?php foreach ($sites as $_site) : ?>
		<tr>
			<td>
				<a href="/sites/settings/company_id/<?= $company_id; ?>/site_id/<?= $_site['site_id'] ?>"><?= $_site['name']; ?></a>
			</td>
			<td><?= $_site['domain']; ?></td>
			<td><?= $_site['external_name']; ?></td>
			<td>
                <?php
                $this->widget('bootstrap.widgets.TbButton',
                    array(
                        'buttonType' => TbButton::BUTTON_LINK,
                        'type' => TbButton::TYPE_LINK,
                        'url'=>'#',
                        'label'=> 'Удалить',
                        'htmlOptions' => array(
                            'class' => 'del-site',
                            'data-url' => $this->createUrl('delete', array('id' => $_site['site_id'])),
                            'data-redirect-url' => $this->createUrl('list', array('company_id' => $company_id)),
                            'data-site-name' => $_site['name'],
                        ),
                    )
                );
                ?>
            </td>
		</tr>
	<?php endforeach ?>
</table>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>$sign['type'], 'url'=>'/sites/createform/company_id/'.$company_id, 'type'=>'primary', 'label'=> 'Создать сайт', 'disabled' => $sign['disabled']))?>
<?php if(isset($sign['text'])):?>
	<br /><br />
	<div style='font-size: 13px;'><i><?= $sign['text']; ?></i></div>
<?php endif; ?>