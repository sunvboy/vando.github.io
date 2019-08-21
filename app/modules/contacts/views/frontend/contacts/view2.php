<div id="contact-page" class="page-body bg-gray">
	<div class="breadcrumb bg_white">
		<div class="uk-container uk-container-center">
			<ul class="uk-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>" title="<?php echo $this->lang->line('home_page') ?>">
						<?php echo $this->lang->line('home_page') ?>
					</a>
				</li>
				<li class="uk-active">
					<a href="feedback.html" title="Feedback">
						Feedback
					</a>
				</li>
			</ul>
		</div>
	</div>
	<section class="page-contact mt20">
		<div class="uk-container uk-container-center">
			<section class="panel-body">
				<div class="uk-grid uk-grid-medium">
					<div class="uk-width-large-1-2 mb20">
						<div class="contact-infomation">
							<div class="contact-map">
								<?php echo $this->fcSystem['contact_map'] ?>
								<style>.contact-map iframe {width: 100%;height: 100%; min-height: 460px;}</style>
							</div>
						</div>
					</div>
					<div class="uk-width-large-1-2 mb20">
						<div class="contact-infomation uk-clearfix mb20">
							<div class="thumb">
								<img src="<?php echo $this->fcSystem['homepage_logo'] ?>" alt="<?php echo $this->fcSystem['homepage_company'] ?>"/>
							</div>
							<div class="infor">
								<h1 class="title"><?php echo $this->fcSystem['homepage_company'] ?></h1>
								<div class="description">
									<?php echo $this->fcSystem['homepage_logo1'] ?>
								</div>
							</div>
						</div>
						<?php $name = $this->input->get('name'); ?>
						<div class="contact-form">
							<div class="label mb10">Bitte füllen Sie das Formular aus und senden Sie es an uns. Unsere Berater werden Ihnen so schnell wie möglich antworten.</div>
							<form action="" method="post" class="uk-form form">
							<?php $error = validation_errors(); echo !empty($error) ? '<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;">'.$error.'</div>' : '';?>
								<div class="uk-grid lib-grid-20 uk-grid-width-small-1-2 uk-grid-width-large-1-1">
									<div class="form-row mb10">
										<input type="text" name="fullname" value="<?php echo ((!empty($name) ? $name : '')) ?>" class="uk-width-1-1 input-text" placeholder="z.B. Zahnarzt oder Dr. Müller *" />
									</div>
								</div><!-- end .uk-grid -->
								<div class="form-row mb10">
									<textarea name="message" value="" class="uk-width-1-1 form-textarea" style="height: 175px;" placeholder="Nachricht *"></textarea>
								</div>
								<div class="form-row uk-text-left">
									<input type="hidden" name="title" value="Feedback Doctor" />
									<input type="submit" name="create" class="btn-submit" value="Feedback" />
								</div>
							</form><!-- end .form -->
						</div><!-- end .contacts -->
					</div>
				</div>
			</section>
		</div>
	</section>
</div>