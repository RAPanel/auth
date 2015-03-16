<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableAjaxValidation' => true,
)); ?>
<h1 class="h1"><?= $this->pageTitle ?></h1>

<div class="form register">

    <? $name = 'email'; ?>
    <div class="line">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->textField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
        </div>
    </div>

    <? $name = 'password'; ?>
    <div class="line">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->passwordField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
        </div>
    </div>

    <? $name = 'password_repeat'; ?>
    <div class="line">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->passwordField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
        </div>
    </div>

    <? $name = 'username'; ?>
    <div class="line">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->textField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
        </div>
    </div>

    <div class="line">
        <?= CHtml::htmlButton('Регистрация', array('class' => 'button', 'type' => 'submit')); ?>
    </div>

    <div class="clearfix"></div>
</div>

<?php $this->endWidget(); ?>
