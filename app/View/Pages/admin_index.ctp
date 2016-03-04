<div class="main-container col2-left-layout">
    <div class="main">
        <div class="col-main">
            <div class="category-products">
                <h3>Список страниц</h3> 
<?php if ( $pages ): ?>
<ul>
<?php foreach($pages as $p): ?>
    <li><?php echo $p['Page']['title']; ?> | <a href="/admin/page/edit/<?php echo $p['Page']['id']; ?>">Изменить</a> | <?php echo $this->Form->postLink('Удалить', array('controller' => 'pages', 'action' => 'delete', $p['Page']['id']), array('confirm' => 'Удалить страницу?')); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>  
            </div>
        </div><!-- .col-main -->
        
<!--Левый сайдбар -->
<?php echo $this->element('menu_sidebar'); ?>
        
    </div><!-- .main -->
    <div style="display: none;" id="back-top"> <a href="#"><img alt="" src="/images/backtop.gif"/></a> </div>
</div>