<?php
/**
 * @var $model User
 */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableAjaxValidation' => true,
));
?>

    <h1><?= $this->pageTitle ?></h1>

    <div class="form login">
        <div style="margin-left:75px"><?php echo $form->error($model, 'password'); ?></div>

        <? $name = 'email'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->textField($model, $name); ?>
                <?= CHtml::Link('я еще не зарегистрирован', array('site/register'), array('class' => 'register')) ?>
                <div class="hint">например, mail@mail.ru</div>
            </div>
        </div>

        <? $name = 'password'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->passwordField($model, $name); ?>
                <?= CHtml::Link('я не помню пароль', array('site/restore'), array('class' => 'restore-password')) ?>
                <div class="hint">не менее 6 символов</div>
            </div>
        </div>

        <? $name = 'rememberMe'; ?>
        <div class="row rememberMe">
            <?php echo $form->checkBox($model, $name, array('class' => 'styled')); ?>
            <?php echo $form->label($model, $name); ?>
        </div>
        <div class="clear"></div>

        <div class="row button"><?= CHtml::submitButton('Вход', array('class' => 'green-button')); ?></div>

    </div>


<?php $this->endWidget(); ?>