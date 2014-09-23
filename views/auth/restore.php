<?php
/**
 * @var $model User
 */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'restore-form',
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

        <div class="clear"></div>

        <div class="row button"><?= CHtml::submitButton('Восстановить', array('class' => 'green-button')); ?></div>

    </div>


<?php $this->endWidget(); ?>