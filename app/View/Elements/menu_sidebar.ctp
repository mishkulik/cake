<div class="col-left sidebar">
    <div class="magicat-container">
        <div class="block">
            <div class="block-title cat_heading">
                <strong><span>Управление категориями</span></strong>
            </div>
            <ul id="magicat">
                <li>
                    <span class="magicat-cat">
                        <a href="/admin/category/add"><span>Добавить категорию</span></a>
                    </span>
                </li>
<?php if ( !empty($cat_id) ): ?>
                <li>
                    <span class="magicat-cat">
                        <a href="/admin/category/edit/<?php echo $cat_id; ?>"><span>Изменить категорию</span></a>
                    </span>
                </li>
                <li>
                    <span class="magicat-cat">
                        <?php echo $this->Form->postLink('Удалить категорию', "/admin/category/delete/{$cat_id}", array('confirm' => 'Удалить категорию?')); ?>
                    </span>
                </li>
<?php endif; ?>
            </ul>
        </div>
<?php if ( !empty($cat_id) ): ?>
        <div class="block">
            <div class="block-title cat_heading">
                <strong><span>Управление товарами</span></strong>
            </div>
            <ul id="magicat">
                <li>
                    <span class="magicat-cat">
                        <a href="/admin/product/add/<?php echo $cat_id; ?>"><span>Добавить товар</span></a>
                    </span>
                </li>
            </ul>
        </div>
<?php endif; ?>
        <div class="block">
            <div class="block-title cat_heading">
                <strong><span>Управление страницами</span></strong>
            </div>
            <ul id="magicat">
                <li>
                    <span class="magicat-cat">
                        <a href="/admin/page"><span>Список страниц</span></a>
                    </span>
                </li>
                <li>
                    <span class="magicat-cat">
                        <a href="/admin/page/add"><span>Добавление страницы</span></a>
                    </span>
                </li>
            </ul>
        </div>
        
    </div><!-- .magicat-container -->
</div>