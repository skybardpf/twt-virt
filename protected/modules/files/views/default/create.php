<?php
/**
 * @var $this Controller
 * @var $new_file Files
 * @var $new_dir Files
 */
?>
<div class="accordion" id="file_create_forms">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#file_create_forms" href="#dir_create">
				Создать папку
			</a>
		</div>
		<div id="dir_create" class="accordion-body collapse<?=($new_dir->errors?' in':'')?>">
			<div class="accordion-inner">
				<?php
				/** @var $form TbActiveForm*/
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id'=>'dir-create-form',
					'type'=>'inline',
					'enableAjaxValidation'=>true,
				))?>
				<?php echo $form->errorSummary($new_dir); ?>
				<fieldset>
					<?=$form->textFieldRow($new_dir, 'name')?>
					<?=$form->hiddenField($new_dir, 'is_dir')?>
					<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Создать'))?>
				</fieldset>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#file_create_forms" href="#file_create">
				Загрузить файл
			</a>
		</div>
		<div id="file_create" class="accordion-body collapse<?=($new_file->errors?' in':'')?>">
			<div class="accordion-inner">
				<?php echo $form->errorSummary($new_file); ?>
				<fieldset>
                    <?php

                    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'   =>'file-upload-form',
                        'type' =>'horisontal',
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array('enctype' => 'multipart/form-data')
                    ));
                    echo CHtml::hiddenField('MAX_FILE_SIZE', $new_file->maxSize);
                    echo $form->hiddenField($new_file, 'is_dir');

                    $this->widget('CMultiFileUpload', array(
                        'name' => 'upload_files',
//            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
//                    'accept' => $accept_ext,
                        'duplicate' => 'Файл с таким именем уже выбран!',
                        'denied' => 'Неправильный тип файла',
                        'htmlOptions' => array(
                            'multiple' => 'multiple',
                        ),
                    ));
                    $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=> 'Загрузить'));
                    $this->endWidget();
                    ?>
				</fieldset>

			</div>
		</div>
	</div>
</div>