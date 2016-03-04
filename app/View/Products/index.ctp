<!-- Карточка товара -->
<div class="main-container col1-layout">
	<div class="main">
		<div class="col-main">
			<div id="messages_product_view"></div>
			<div class="product-view">
				<div class="product-essential">
					<!--Start Product Information Right-->
					<div class="product-shop">
						<!--Product Title-->
						<div class="product-name">
							<h1><?=$product['Product']['title']?></h1>
						</div>
<?php if ($product['Product']['is_new'] == '1'): ?>
						<p class="availability in-stock"><span>In stock</span></p>
<?php endif; ?>                        
						<div class="price-box"> <span class="regular-price" id="product-price-167"> <span class="price">$ <?=$product['Product']['price']?></span> </span> </div>
						<div class="content">
							<?=$product['Product']['body']?>
						</div>
					</div>
					<!--End Product Information Right-->
<?php $img = $product['Product']['img'] ? $product['Product']['img'] : 'no_image.png'; ?>
					<!--Start Product Image Zoom Left-->
					<div class="product-img-box">
						<p class="product-image product-image-zoom">
                            <a href='/<?php echo IMAGES_URL.'products_img/'.$img; ?>' class = 'cloud-zoom' id='zoom1' rel="adjustX: 10, adjustY:-4"><img style="max-height:400px; width:400px;" src="/<?php echo IMAGES_URL.'products_img/'.$img; ?>" alt='' title="Optional title display" />
                            </a>
                        </p>
					</div>
					<!--End Product Image Zoom Left-->
					<div class="clearer"></div>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;" id="back-top"> <a href="#"><img alt="" src="/images/backtop.gif" /></a> </div>
</div>
<!-- Карточка товара -->