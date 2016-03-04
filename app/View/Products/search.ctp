<div class="main-container col2-left-layout">
    <div class="main">
        <div class="col-main">
            <!--Category Title-->

            <!--Category Image-->

            <div class="category-products">
<?php if (!is_array($search_res)): ?>
<h3><?php echo $search_res; ?></h3>
<?php elseif ( !empty($search_res) ): ?>

        <!--Начало верхней пагинации-->
        <div class="toolbar">
            <div class="pagination">
                <div class="pages"> <strong>Страница:</strong>
                <?php 
                    echo $this->Paginator->counter(array(
                    'separator' => ' из '
                ));
                ?>
                <?php echo $this->Paginator->first(' <<'); ?>
                <ol>
                <?php 
                    echo $this->Paginator->numbers(array(
                        'tag' => 'li',
                        'modulus' => 2
                    ));
                ?>
                </ol>
                <?php echo $this->Paginator->last('>>'); ?>
                </div>
            </div>
        </div>
        <!--Конец верхней пагинации-->
        
        <!--Начало списка товаров категории-->
<ul class="products-grid first odd">
<?php $i = 1; foreach($search_res as $product): ?>
<?php $class = ($i % 3 == 0) ? 'last' : 'first'; ?>
    <li class="item <?php echo $class; ?>">
        <a href="/product/<?php echo $product['Product']['id']; ?>" title="<?=h($product['Product']['title'])?>" class="product-image"><?php echo $this->Html->image('products_img/thumbs/'.$product['Product']['img'], array('alt' => h($product['Product']['title']))); ?></a>
        <h2 class="product-name">
            <a href="/product/<?php echo $product['Product']['id']; ?>" title="<?=h($product['Product']['title'])?>"><?=h($product['Product']['title'])?></a>
        </h2>
        <div class="price-box">
            <span class="regular-price">
                <span class="price">$<?=h($product['Product']['price'])?></span>
            </span>
        </div>
        <div class="actions">
        <button type="button" title="Add to Cart" class="button btn-cart">
            <span>
                <span>В корзину</span>
            </span>
        </button>
        <a href="<?php echo '/'.IMAGES_URL.'products_img/zoom1.jpg'; ?>" class="fancybox quick_view">Предпросмотр</a>
        <ul class="add-to-links">
            <li>
                <a href="#" class="link-wishlist">Add to Wishlist</a>
            </li>
            <li class="last">
                <a href="#" class="link-compare">Add to Compare</a>
            </li>
        </ul>
        </div>
    </li>
<?php $i++; endforeach; ?>
</ul>
    <!--Конец списка товаров категории-->
    
<!--Начало нижней пагинации-->
<div class="toolbar-bottom">
    <div class="toolbar">
        <div class="pagination">
            <div class="pages"> <strong>Страница:</strong>
            <?php 
                echo $this->Paginator->counter(array(
                'separator' => ' из '
            ));
            ?>
            <?php echo $this->Paginator->first(' <<'); ?>
            <ol>
            <?php 
                echo $this->Paginator->numbers(array(
                    'tag' => 'li',
                    'modulus' => 2
                ));
            ?>
            </ol>
            <?php echo $this->Paginator->last('>>'); ?>
            </div>
        </div>
    </div>
</div>
<!--Конец нижней пагинации-->
<?php else: ?>
<h3>По вашему запросу ничего не найдено...</h3>
<?php endif; ?>
            </div> <!-- category-products -->
            
        </div> <!-- .col-main -->
        
        <!--Начало левого сайдбара категорий-->
        <div class="col-left sidebar">
            <div class="magicat-container">
                <div class="block">
                    <div class="block-title cat_heading">
                        <strong><span><?=$cats_menu_sidebar[$cat_id][$cat_id]?></span></strong>
                    </div>
            <?php if( !empty($cats_menu_sidebar[$cat_id]['Children']) ): ?>
                    <ul id="magicat">
            <?php foreach($cats_menu_sidebar[$cat_id]['Children'] as $key => $item): ?>
                        <li class="level0-inactive level0 inactive">
                            <span class="magicat-cat">
                                <a href="/category/<?=$key?>"><span><?=$item?></span></a>
                            </span>
                        </li>
            <?php endforeach; ?>
                    </ul>
            <?php endif; ?>
                </div>
            </div>
        </div>
        <!--Конец левого сайдбара категорий-->

    </div><!-- .main -->
    <div style="display: none;" id="back-top"> 
        <a href="#"><img alt="" src="/images/backtop.gif"/></a>
    </div>
</div> 