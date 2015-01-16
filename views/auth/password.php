<?php
/**
 * @var PasswordForm $model
 * @var CActiveForm $form
 */

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'password-form',
    'enableAjaxValidation' => true,
));
?>

    <div class="container">
        <div class="form password">
            <h1 class="h1"><?= $this->pageTitle ?></h1>
            <?php if (Yii::app()->user->getState('tokenAuth', false) !== true): ?>
                <? $name = 'oldPassword'; ?>
                <div class="line">
                    <?php echo $form->labelEx($model, $name); ?>
                    <div class="elements">
                        <?php echo $form->passwordField($model, $name); ?>
                        <?php echo $form->error($model, $name); ?>
                    </div>
                </div>
            <?php endif; ?>

            <? $name = 'newPassword'; ?>
            <div class="line">
                <?php echo $form->labelEx($model, $name); ?>
                <div class="elements">
                    <?php echo $form->passwordField($model, $name); ?>
                    <?php echo $form->error($model, $name); ?>
                </div>
            </div>

            <? $name = 'newPasswordRepeat'; ?>
            <div class="line">
                <?php echo $form->labelEx($model, $name); ?>
                <div class="elements">
                    <?php echo $form->passwordField($model, $name); ?>
                    <?php echo $form->error($model, $name); ?>
                </div>
            </div>

            <div class="line changePassword">
                <?= CHtml::htmlButton('Изменить пароль', array('class' => 'button', 'type' => 'submit')); ?>
            </div>
        </div>
    </div>


<?php $this->endWidget(); ?>