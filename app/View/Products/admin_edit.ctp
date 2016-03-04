<h3>Редактирование товара <?php echo $product['Product']['title']; ?></h3>
<?php
echo $this->Form->create('Product', array('type' => 'file'));
//echo $this->Form->input('category_id', array('label' => 'Категория'));
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
echo $this->Form->input('price', array('label' => 'Цена'));
echo $this->Form->input('img', array('label' => 'Картинка товара', 'type' => 'file'));
echo $this->Form->input('is_new', array('label' => 'Новинка', 'type' => 'checkbox'));
if ( $product['Product']['img'] ) {
    echo '<p>'.$this->Html->image('products_img/thumbs/'.$product['Product']['img']).$this->Form->input('del_img', array('type' => 'checkbox', 'label' => 'Удалить картинку')).'</p>';
}
echo $this->Form->end('Редактировать');
?>
<script>
CKEDITOR.replace('editor1');
</script>