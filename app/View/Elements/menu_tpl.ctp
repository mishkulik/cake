<li>
    <a href="<?=$admin;?>/category/<?=$category['Category']['id']?>"><?php echo $category['Category']['title']; ?></a>
    <?php if ($category['children']): ?>
    <ul>
        <?php echo $this->_catMenuHtml($category['children'], $admin); ?>
    </ul>
    <?php endif; ?>
</li>