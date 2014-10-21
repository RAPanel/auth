<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableAjaxValidation' => true,
)); ?>

<h1><?=$this->pageTitle?></h1>

<div class="form register">

    <? $name = 'email'; ?>
    <div class="row">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->textField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
            <div class="hint">например, mail@mail.ru</div>
        </div>
    </div>

    <? $name = 'password'; ?>
    <div class="row">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->passwordField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
            <div class="hint">не менее 6 символов</div>
        </div>
    </div>

    <? $name = 'password_repeat'; ?>
    <div class="row">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->passwordField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
            <div class="hint">пароли должны совпадать</div>
        </div>
    </div>

    <? $name = 'username'; ?>
    <div class="row">
        <?php echo $form->labelEx($model, $name); ?>
        <div class="inline">
            <?php echo $form->textField($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
            <div class="hint">этим именем будут подписываться все Ваши публикации<br> имя должно быть на русском
                языке не более двух слов
            </div>
        </div>
    </div>

    <div class="row button"><?= CHtml::submitButton('Регистрация', array('class' => 'green-button')); ?></div>
</div>

<?php $this->endWidget(); ?>