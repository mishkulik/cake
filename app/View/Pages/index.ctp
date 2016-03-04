<!-- Карточка товара -->
<div class="main-container col1-layout">
	<div class="main">
		<div class="col-main">
			<div class="product-view">
				<div class="product-essential">
					<!--Начало вывода контента страницы-->
						<div class="product-name">
			<h1><?php echo $page['Page']['title'];?></h1>
						</div>
						<div class="content">
			<p><?php echo $page['Page']['body'] ;?></p>
                            
                            <!-- Форма обратной связи -->
            <?php if (count($this->request->pass) == 1 && $this->request->pass[0] == 'contacts'): ?>
            <?php echo $this->element('contact_mail'); ?>
            <?php endif; ?>
						</div>
					<!--Конец вывода контента страницы-->
					<div class="clearer"></div>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;" id="back-top"> <a href="#"><img alt="" src="/images/backtop.gif" /></a> </div>
</div>
<!-- Карточка товара -->