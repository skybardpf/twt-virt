<?php
/**
 * @var SitesController $this
 * @var integer $site_id
 * @var integer $company_id
 * @var array $site
 * @var array $templates
 */
?>

<?php
echo CHtml::tag('h3', array(), 'Настройка сайта');

echo CHtml::link(
    Yii::t('app', 'Настройки сайта'),
    $this->createUrl('settings',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id
        )
    ),
    array(
        'style' => 'color: black;',
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Главная'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'main',
        )
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'О компании'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'about',
        )
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Партнёры'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'partners',
        )
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Услуги'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'services',
        )
    )
);
echo '&nbsp;|&nbsp;';
echo CHtml::link(
    Yii::t('app', 'Контакты'),
    $this->createUrl('page',
        array(
            'cid' => $this->company->primaryKey,
            'site_id' => $site_id,
            'kind' => 'contacts',
        )
    )
);
echo '<br/><br/>';

/**
 * @var TbActiveForm $form
 */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>

    <div class="control-group ">
        <label for="domain" class="control-label">Домен</label>
        <div class="controls">
            <input disabled="disabled" type='text' name='domain' id='domain' value='<?= $site['domain']; ?>'>
        </div>
    </div>
    <div class="control-group ">
        <?php if (isset($errors['sitename'])): ?>
            <div style='color: red; margin-left: 190px; font-size: 12px;'>
                <i><?= $errors['sitename']; ?></i>
            </div>
        <?php endif; ?>
        <label for="sitename" class="control-label required">Название сайта <span class="required">*</span></label>

        <div class="controls">
            <input type='text' name='sitename' id='sitename' value='<?= $site['name']; ?>'>
        </div>
    </div>

    <script>
        function t_ch() {
            var el = document.getElementById('template');
            var img = document.getElementById('t_img');

            if (el.value == '1') {
                img.src = "http://<?= $_SERVER['HTTP_HOST']; ?>/upload/templ_1.png";
            }
            if (el.value == '2') {
                img.src = "http://<?= $_SERVER['HTTP_HOST']; ?>/upload/templ_2.png";
            }
        }
    </script>
    <div class="control-group ">
        <label for="template" class="control-label required">Шаблон <span class="required">*</span></label>

        <div class="controls">
            <select name='template' id="template" onchange='t_ch();'>
                <?php foreach ($templates as $_templ) : ?>
                    <option <?php if ($site['template'] == $_templ['id']) echo "selected"; ?>
                        value='<?= $_templ['id']; ?>'><?= $_templ['external_name']; ?></option>
                <?php endforeach ?>
            </select>
            <img src='#' id='t_img' width='70'/>
            <script>
                t_ch();
            </script>
        </div>
    </div>
    <div class="control-group ">
        <label for="logo" class="control-label">Логотип</label>
        <?php if (!empty($site['logo'])): ?>
            <div style='margin: 5px 0 0 180px; font-size: 12px; font-style: italic;'>
                <div>Размеры логотипа: <br/> Ширина - не больше 350px<br/> Высота - не больше 50px</div>
                <img src="http://<?= $_SERVER['HTTP_HOST'] . $site['logo']; ?>">
            </div>
        <?php endif; ?>
        <div class="controls">
            <input type='file' name='logo' id='logo'>
        </div>
    </div>
    <div class="control-group ">
        <label for="about" class="control-label">О компании</label>

        <div class="controls">
            <input type='checkbox' name='about' id='about' <?php if ($site['about'] == "yes") echo "checked"; ?>>
        </div>
    </div>
    <div class="control-group ">
        <label for="services" class="control-label">Услуги</label>

        <div class="controls">
            <input type='checkbox' name='services'
                   id='services' <?php if ($site['services'] == "yes") echo "checked"; ?>>
        </div>
    </div>
    <div class="control-group ">
        <label for="partners" class="control-label">Партнёры</label>

        <div class="controls">
            <input type='checkbox' name='partners'
                   id='partners' <?php if ($site['partners'] == "yes") echo "checked"; ?>>
        </div>
    </div>
    <div class="control-group ">
        <label for="contacts" class="control-label">Контакты</label>

        <div class="controls">
            <input type='checkbox' name='contacts'
                   id='contacts' <?php if ($site['contacts'] == "yes") echo "checked"; ?>>
        </div>
    </div>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Сохранить')) ?>

<?php $this->endWidget(); ?>