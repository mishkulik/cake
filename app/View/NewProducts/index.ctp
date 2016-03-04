<div class="main-container col1-layout">
    <!--Start of Home Content-->
    <div class="main">
        <div class="col-main">
            <div class="std">
                <!--Start Banner-->
                <div class="banner_box">
                    <div class="slider-wrapper banner">
                        <!--Place your banner images-->
                        <div id="slider" class="banner_slider"> <a href="#"><img src="images/banner_1.jpg" alt="" /></a> <a href="#"><img src="images/banner_2.jpg" alt="" /></a> <a href="#"><img src="images/banner_3.jpg" alt="" /></a> <a href="#"><img src="images/banner_4.jpg" alt="" /></a> </div>
                    </div>
                    <div class="promotional_block"> <!--Place your promotional images-->
                    <div class="block_one"> <a href="#"><img src="images/promo1.jpg" alt="" /></a> </div>
                    <div class="block_one"> <a href="#"><img src="images/promo2.jpg" alt="" /></a> </div>
                    <div class="block_two"> <a href="#"><img src="images/promo3.jpg" alt="" /></a> </div>
                </div>
            </div>
            <!--End Banner-->
            <!--Start New Products-->
            <div class="box-center">
                <?php if ($new_products): ?>
                <div class="special">
                    <div style="visibility: visible;" id="mix_container" class="mix_container">
                        <h1 class="category_page_title"> New Products</h1>
                        <?php if (count($new_products) > 10): ?>
                        <div class="mix_nav">
                            <span id="mix_prev" class="mix_prev">Previous</span>
                            <span id="mix_next" class="mix_next">Next</span>
                        </div>
                        <?php endif; ?>
                        <div id="container" class="mix_wrapper">
                            <ul style="position: relative;" class="mix_gallery">
<?php $i = 1; foreach ($new_products as $product): ?>
<?php $img = $product['Product']['img'] ? $product['Product']['img'] : 'no_image.png'; ?>
    <li class="item mix_row <?php if ($i % 5 == 0) echo 'last'; ?>">
        <div class="outer box"> <a href="/product/<?php echo $product['Product']['id']; ?>" class="product-image"><?php echo $this->Html->image('products_img/thumbs/'.$img, array('alt' => h($product['Product']['title']))); ?></a>
            <div class="ic_caption">
                <h2 class="product-name"><a href="/product/<?php echo $product['Product']['id']; ?>" title="<?=h($product['Product']['title'])?>"><?=h($product['Product']['title'])?></a></h2>
                <div class="actions">
                    <button style="display:none;" type="button" title="Add to Cart" class="button btn-cart">
                        <span>Add to Cart</span> 
                    </button>
                    <a rel="example_group" href="<?php echo IMAGES_URL.'products_img/'.$img; ?>" class="fancybox quickllook" id="fancybox170">Быстрый просмотр</a>
                    <div class="price-box">
                        <span class="regular-price">
                            <span class="price"><?=h($product['Product']['price'])?> руб.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </li>
<?php $i ++; endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    </div><!-- .special -->
                    <?php endif; ?>
                </div>
                <!--End New Products-->
            </div>
        </div>
    </div><!-- .main -->
    <!--End of Home Content-->
</div><!-- .main-container col1-layout -->
<div style="display: none;" id="back-top"> <a href="#"><img alt="" src="images/backtop.gif" /></a></div>