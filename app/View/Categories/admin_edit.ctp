<h3>Редактирование категории "<?php echo $category['Category']['title']; ?>"</h3>
<?php
echo $this->Form->create('Category');
echo $this->Form->input('title', array('label' => 'Название категории'));
?>
<div class="input select">
    <label for="CategoryParentId">Выбор родительской категории</label>
    <select id="CategoryParentId" name="data[Category][parent_id]">
        <option value="0">Самостоятельная категория</option>
        <?php echo $categories; ?>
    </select>
</div>
<?php
//echo $this->Form->input('parent_id');
echo $this->Form->end('Сохранить');
?>
<script>
CKEDITOR.replace('editor1');
</script>