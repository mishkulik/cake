<h3>Добавление нового товара</h3>
<?php
echo $this->Form->create('Product', array('type' => 'file'));
?>
<div class="input select">
    <label for="ProductCategoryId">Категория</label>
    <select id="ProductCategoryId" name="data[Product][category_id]">
        <?php echo $categories; ?>
    </select>
</div>
<?php
echo $this->Form->input('title', array('label' => 'Название товара'));
echo $this->Form->input('body', array('label' => 'Описание', 'id' => 'editor1'));
echo $this->Form->input('price', array('label' => 'Цена', 'value' => 0));
echo $this->Form->input('img', array('label' => 'Картинка товара', 'type' => 'file'));
echo $this->Form->input('is_new', array('label' => 'Новинка', 'type' => 'checkbox'));
echo $this->Form->end('Добавить');
?>
<script>
CKEDITOR.replace('editor1');
</script>