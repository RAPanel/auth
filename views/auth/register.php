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
        аккаунт <?=CHtml::link('войти', array('user/login', 'ajax' => $_GET['ajax']), array('class' => 'login'))?></h2>

    <div
        class="center"><?= CHtml::link('Войти через социальные сети', LoginzaModel::getLoginzaUrl(), array('class' => 'loginza')); ?></div>

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

        <? $name = 'deal'; ?>
        <div class="row rememberMe">
            <?php echo $form->checkBox($model, $name, array('class' => 'styled')); ?>
            <?php echo $form->labelEx($model, $name); ?>
            <?php echo $form->error($model, $name); ?>
        </div>

        <? $name = 'verified'; ?>
        <div class="row">
            <?php echo $form->labelEx($model, $name); ?>
            <div class="inline">
                <span class="verified"><?=$model->code?></span>
                <?php echo $form->textField($model, $name, array('class' => 'mini')); ?>
                <?php echo $form->error($model, $name); ?>
                <div class="hint">введите сумму чисел</div>
            </div>
        </div>

        <div class="row button"><?= CHtml::submitButton('Регистрация', array('class' => 'green-button')); ?></div>

        <?//= CHtml::Link('Авторизация', array('user/login')) ?>
    </div>

    <?php $this->endWidget(); ?>
<?endif; ?>