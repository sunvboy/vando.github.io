<div id="homepage" class="page-body">
	<div class="wrapper uk-clearfix">
		<?php $this->load->view('homepage/frontend/common/aside-1');?>
		<section class="main-content big">
			<section class="project-catalogue">
				<header class="panel-head">
					<h1 class="heading-2"><span>Dự án theo địa điểm</span></h1>
				</header>
				<?php if(isset($projectsList) && is_array($projectsList) && count($projectsList)){ ?>
				<section class="panel-body">
					<ul class="uk-grid uk-grid-collapse uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-2 list-article">
						<?php foreach($projectsList as $key => $val) { ?> 
						<?php 
							$title = $val['title'];
							$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'projects');
							$image = getthumb($val['images']);
							$description = cutnchar(strip_tags($val['description']), 250);
							$area = $val['area'];
							$viewed = $val['viewed'];
							$price = $val['price'];
							$city = $this->Autoload_Model->_get_where(array(
								'select' => '*',
								'table' => 'province',
								'where' => array('id' => $val['cityid'])
							));
							$district = $this->Autoload_Model->_get_where(array(
								'select' => '*',
								'table' => 'province',
								'where' => array('id' => $val['districtid'])
							));
						?>
						<li>
							<article class="article">
								<div class="thumb">
									<a class="image img-cover" href="<?php echo $href; ?>" title="<?php echo $title; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" /></a>
								</div>
								<div class="infor">
									<h2 class="title"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
									<div class="desc uk-clearfix">
										<div class="item"><span class="label">Diện tích:</span> <span class="value"><?php echo $area; ?> m2</span></div>
										<div class="item"><span class="label">Hướng:</span> <span class="value">
											<?php if(isset($val['attribute']) && is_array($val['attribute']) && count($val['attribute'])){ ?>
											<?php foreach($val['attribute'] as $keyAttr => $valAttr){ ?>
											<?php if($valAttr['keyword'] != 'huong-nha') continue; ?>
											<?php if(isset($valAttr['attr']) && is_array($valAttr['attr']) && count($valAttr['attr'])){ ?>
											<?php foreach($valAttr['attr'] as $keyAttribute => $valAttribute){ ?>
												<?php echo $valAttribute['title'] ?>
											<?php }}}} ?>
										</span></div>
										<div class="item"><span class="label">Giá: </span> <span class="value"><?php echo number_format($val['price']).'.000đ'; ?></span></div>
										<div class="item"><span class="label">Lượt xem:</span> <span class="value"><?php echo $val['viewed']; ?></span></div>
										<div class="item"><span class="label">Vị trí:</span> <span class="value"><?php echo $district['title']; ?> - <?php echo $city['title']; ?></span></div>
									</div>
								</div><!-- .infor -->
							</article><!-- .article -->
						</li>
						<?php } ?>
					</ul>
					<?php echo (isset($PaginationList)) ? $PaginationList: ''; ?>
				</section><!-- .panel-body -->
				<?php } ?>
			</section><!-- .project-catalogue -->
		</section><!-- .main-content -->
		<?php $this->load->view('homepage/frontend/common/aside-2');  ?>
	</div><!-- .wrapper -->
	
</div><!-- .page-body -->