<?php
/**
 * @var User $model
 * @var CActiveForm $form
 */
?>

    <? $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => true,
    ));
    ?>
    <h1 class="h1"><?= $this->pageTitle ?></h1>

    <div class="form login">
        <? $name = 'email'; ?>
        <div class="line">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->textField($model, $name); ?>
                <?= CHtml::Link('я еще не зарегистрирован', array('auth/register'), array('class' => 'register')) ?>
            </div>
        </div>

        <? $name = 'password'; ?>
        <div class="line">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->passwordField($model, $name); ?>
                <?= CHtml::Link('я не помню пароль', array('auth/restore'), array('class' => 'restore-password')) ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
        </div>

        <? $name = 'rememberMe'; ?>
        <div class="line rememberMe">
            <?php echo $form->checkBox($model, $name, array('class' => 'styled')); ?>
            <?php echo $form->label($model, $name); ?>
        </div>
        <div class="clear"></div>

        <div class="line">
            <?= CHtml::htmlButton('Вход', array('class' => 'button', 'type' => 'submit')); ?>
        </div>

    </div>

    <?php $this->endWidget(); ?>
