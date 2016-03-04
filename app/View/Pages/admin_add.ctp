<h3>Добавление новой страницы</h3>
<?php
echo $this->Form->create('Page');
echo $this->Form->input('title', array('label' => 'Название страницы'));
echo $this->Form->input('keywords', array('label' => 'Ключевики'));
echo $this->Form->input('description', array('label' => 'Мета-описания'));
echo $this->Form->input('alias', array('label' => 'Алиас'));
echo $this->Form->input('body', array('label' => 'Описание', 'id' => 'editor1'));
echo $this->Form->end('Сохранить');
?>
<script>
CKEDITOR.replace('editor1');
</script>