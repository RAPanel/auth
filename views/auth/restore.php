<?php
/**
 * @var User $model
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
        <div class="line">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->textField($model, $name); ?>
                <?= CHtml::link('я еще не зарегистрирован', array('site/register'), array('class' => 'register')) ?>
            </div>
        </div>

        <div class="clear"></div>

        <div class="line">
            <?= CHtml::htmlButton('Восстановить', array('class' => 'button', 'type'=>'submit')); ?>
        </div>

    </div>


<?php $this->endWidget(); ?>