<?php
/**
 * @var $model User
 */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'password-form',
    'enableAjaxValidation' => true,
));
?>

    <h1><?= $this->pageTitle ?></h1>

    <div class="form password">
        <?php if (Yii::app()->user->getState('tokenAuth', false) !== true): ?>
            <? $name = 'oldPassword'; ?>
            <div class="row">
                <?php echo $form->labelEx($model, $name); ?>
                <div class="inline">
                    <?php echo $form->passwordField($model, $name); ?>
                    <?php echo $form->error($model, $name); ?>
                </div>
            </div>
        <?php endif; ?>

        <? $name = 'newPassword'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->passwordField($model, $name); ?>
                <?php echo $form->error($model, $name); ?>
            </div>
        </div>

        <? $name = 'newPasswordRepeat'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->passwordField($model, $name); ?>
                <?php echo $form->error($model, $name); ?>
            </div>
        </div>

        <div class="row button"><?= CHtml::submitButton('Изменить пароль'); ?></div>

    </div>


<?php $this->endWidget(); ?>