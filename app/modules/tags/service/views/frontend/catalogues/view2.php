<div id="article-page" class="page-body">
	<div class="absulute-page uk-container">
		<header class="panelhead">
			<h1 class="heading"><span><?php echo $Catalog_goc['title'] ?></span></h1>
		</header>
	</div>
	<?php if (isset($list_child) && is_array($list_child) && count($list_child)): ?>
		<section class="box_catalog_child">
			<div class="uk-container uk-container-center">
				<ul class="uk-list uk-flex uk-flex-middle uk-flex-center relative tabchild">
					<?php foreach ($list_child as $key => $val) { ?>
						<?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
						<li class="uk-width-1-1 uk-text-center <?php echo (($hrefC == $canonicalcata) ? 'uk-active' : '') ?>" id="tab<?php echo $key ?>">
							<a href="<?php echo $hrefC ?>" title="<?php echo $val['title'] ?>">
								<?php echo $val['title'] ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php endif ?>

	<div class="uk-container uk-container-center">
		<div class="breadcrumb">
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
						<i class="fa fa-home"></i> <?php echo $this->lang->line('home_page') ?>
					</a>
				</li>
				<?php foreach($Breadcrumb as $key => $val){ ?>
					<?php 
						$title = $val['title'];
						$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues');
					?>
					<li class="uk-active"><a href="<?php echo $href; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<?php if ($DetailCatalogues['isfooter'] == 11){ ?>
			<section class="form-supports mt30">
				<div class="note_message mb20"><?php echo $DetailCatalogues['description'] ?></div>
				<form action="<?php echo site_url('contacts/ajax/contacts/add'); ?>" class="uk-form form" method="post" id="sform4">
					<div class="error uk-alert"></div>
					<div class="box_form_inquiry">
						<div class="uk-grid lib-grid-20">
							<div class="uk-width-large-1-2">
								<div class="line-inquiry mb20 relative">
									<span class="ico ico_user"></span>
									<?php echo form_input('fullname', set_value('fullname'), 'class="input-text uk-width-1-1 fullname" placeholder="'.$this->lang->line('fullname_customers').' *"'); ?>
								</div>
							</div>
							<div class="uk-width-large-1-2">
								<div class="line-inquiry mb20 relative">
									<span class="ico ico_company"></span>
									<?php echo form_input('class', set_value('class'), 'class="input-text uk-width-1-1 class" placeholder="'.$this->lang->line('class_customers').'" '); ?>
								</div>
							</div>
						</div>
						<div class="uk-grid lib-grid-20">
							<div class="uk-width-large-1-2">
								<div class="line-inquiry mb20 relative">
									<span class="ico ico_email"></span>
									<?php echo form_input('email', set_value('email'), 'class="input-text uk-width-1-1 email" placeholder="Email *" '); ?>
								</div>
							</div>
							<div class="uk-width-large-1-2">
								<div class="line-inquiry mb20 relative">
									<span class="ico ico_message"></span>
									<?php echo form_input('title', set_value('title'), 'class="input-text uk-width-1-1 title title" placeholder="'.$this->lang->line('title').' *" '); ?>
								</div>
							</div>
						</div>
						<div class="line-inquiry mb20 relative">
							<?php echo form_textarea('message', set_value('message'), 'class="input-text uk-width-1-1" placeholder="'.$this->lang->line('contact_message').'" style="height: 220px; padding-left: 15px;" '); ?>
						</div>
					</div>
					<div class="mb20 mt20 uk-text-center formBtn">
						<input type="submit" name="create" value="<?php echo $this->lang->line('submit_information') ?>" class="btn message" />
					</div>
					<script type="text/javascript" charset="utf-8">
					    $(document).ready(function(){
					        $('#sform4 .error').hide();
					        var uri = $('#sform4').attr('action');
					        $('#sform4').on('submit',function(){
					            var postData = $(this).serializeArray();
					            $.post(uri, {post: postData, fullname: $('#sform4 .fullname').val(), email: $('#sform4 .email').val(), title: $('#sform4 .title').val(), class: $('#sform4 .class').val(), message: $('#sform4 .message').val()},
					            function(data){
					                var json = JSON.parse(data);
					                $('#sform4 .error').show();
					                if(json.error.length){
					                    $('#sform4 .error').removeClass('uk-alert-success').addClass('uk-alert-danger');
					                    $('#sform4 .error').html('').html(json.error);
					                }else{
					                    $('#sform4 .error').removeClass('uk-alert-danger').addClass('uk-alert-success');
					                    $('#sform4 .error').html('').html('<?php echo $this->lang->line('message_success_subricre') ?>.');
					                    $('#sform4').trigger("reset");
					                    setTimeout(function(){ location.reload(); }, 5000);
					                }
					            });
					            return false;
					        });
					    });
					</script>
				</form>
			</section>
		<?php }elseif ($DetailCatalogues['isfooter'] == 12) { ?>
			
		<?php }else{ ?>
			<div class="uk-grid lib-grid-20 mt30">
				<div class="uk-width-large-1-4 uk-visible-large">
					<?php if (isset($list_child) && is_array($list_child) && count($list_child)): ?>
				  		<?php foreach ($list_child as $keyg => $val) { ?>
				  			<?php $hrefC = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles_catalogues'); ?>
			  				<?php if (isset($val['child']) && is_array($val['child']) && count($val['child'])): ?>
			  					<section class="content_child">
			  						<header class="panel-head">
			  							<div class="heading">
			  								<span>Thể loại</span>
			  							</div>
			  						</header>
						  			<ul class="uk-list uk-list-childbook">
										<?php foreach ($val['child'] as $key => $vals) { ?>
											<?php $hrefC = rewrite_url($vals['canonical'], $vals['slug'], $vals['id'], 'articles_catalogues'); ?>
											<li>
												<a href="<?php echo $hrefC ?>" title="<?php echo $vals['title'] ?>">
													<span aria-hidden="true" class="fa fa-dollar"></span>
													<?php echo $vals['title'] ?>
												</a>
											</li>
										<?php } ?>
									</ul>
								</section>
							<?php endif ?>
						<?php } ?>
					<?php endif ?>
				</div>
				<div class="uk-width-large-3-4">
					<section class="ebook-section">
						<section class="panel-body">
							<?php if(isset($ArticlesList) && is_array($ArticlesList) && count($ArticlesList)){ ?>
								<ul class="uk-grid uk-grid-collapse uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 list-ebook"  data-uk-grid-match="{target: '.article .title'}">
									<?php foreach($ArticlesList as $key => $val) { ?> 
										<?php 
											$href = rewrite_url($val['canonical'], $val['slug'], $val['id'], 'articles');
											$image = getthumb($val['images'], TRUE);
											$description = cutnchar(strip_tags($val['description']),450);
											$title = cutnchar(strip_tags($val['title']),250);
											$created = show_time($val['created'], 'd/m/Y');
											$view = $val['viewed'];
										?>
										<li class="mb20">
				                            <article class="uk-clearfix article">
				                                <div class="thumb">
				                                    <a class="image img-cover" href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
				                                        <img src="<?php echo $image ?>" alt="<?php echo $val['title'] ?>">
				                                    </a>
				                                </div>
				                                <div class="infor">
				                                    <h3 class="title">
				                                        <a href="<?php echo $href ?>" title="<?php echo $val['title'] ?>">
				                                            <?php echo $val['title'] ?>
				                                        </a>
				                                    </h3>
			                                   		<div class="description">
			                                        	<?php //echo $description ?>
			                                    	</div>
				                                </div>
				                            </article>
				                        </li>				
		                            <?php } ?>
		                        </ul>
							<?php }else{ echo '<div class="mt10">'.$this->lang->line('no_data_table').'</div>';} ?>
						</section>
					</section><!-- .article-catalogue -->
				</div>
			</div>
		<?php } ?>
	</div>
</div> <!-- .mainContent -->