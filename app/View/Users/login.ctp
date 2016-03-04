<h3>Авторизация</h3>
<?php
echo $this->Form->create('User');
echo $this->Form->input('username', array('label' => 'Логин'));
echo $this->Form->input('password', array('label' => 'Пароль'));
echo '<br>';
echo $this->Form->end('Войти');