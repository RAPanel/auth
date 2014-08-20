<? if (Yii::app()->user->getFlash('info')): ?>
    <h1>Добро пожаловать на сайт svoipravila.ru <br>Вы успешно прошли регистрацию!</h1>

    <h2>Теперь Вы можете:</h2>

    <div class="form register">
        <ul>
            <li>Оставлять комментарии к публикациям</li>
            <li>Стать автором статей</li>
            <li>Принимать участие в конкурсах</li>
        </ul>
    </div>

    <h2><?=CHtml::link('перейти в личный кабинет', array('private/index'), array('target' => '_parent'))?></h2>
    <h2><?=CHtml::link('вернуться назад', '#close', array('onclick' => 'parent.document.location.reload();return false;'))?></h2>
    <?Yii::app()->clientScript->registerScript('colorbox-close', 'parent.$(parent.document).on("cbox_cleanup", function(){parent.document.location.reload()});');?>

<? else: ?>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    )); ?>

    <h1><?=$this->pageTitle?></h1>

    <h2>у меня уже есть
        аккаунт <?=CHtml::link('войти', array('site/login'), array('class' => 'login'))?></h2>

    <? //= $form->errorSummary($model) ?>
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

        <? $name = 'name'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <?php echo $form->textField($model, $name); ?>
                <?php echo $form->error($model, $name); ?>
            </div>
        </div>

        <div class="row button"><?= CHtml::submitButton('Регистрация', array('class' => 'green-button')); ?></div>
    </div>

    <?php $this->endWidget(); ?>
<?endif; ?>