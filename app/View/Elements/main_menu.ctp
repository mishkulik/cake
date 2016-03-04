<ul class="menu">
    <li><a href="<?=FULL_BASE_URL;?>">Главная</a></li>
<?php if (!empty($main_menu)): ?>
<?php foreach($main_menu as $item_menu): ?>
    <li><a href="/page/<?=$item_menu['Page']['alias'];?>"><?=$item_menu['Page']['title'];?></a></li>
<?php endforeach; ?>
<?php endif; ?>
</ul>