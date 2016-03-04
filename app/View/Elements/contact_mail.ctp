<h3>Если хотите связаться с нами, заполните форму ниже:</h3>
<?php echo $this->Session->flash(); ?>
<?php
    echo $this->Form->create('', array('url' => array(
        'controller' => 'pages', 
        'action' => 'sendmail')
    ));
    echo $this->Form->input('subject', array('label' => 'Тема письма'));
    echo $this->Form->input('email', array('label' => 'Ваш email'));
    echo $this->Form->input('body', array('label' => 'Текст Вашего сообщения'));
    echo $this->Form->end('Отправить');