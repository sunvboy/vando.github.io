<section class="sec-content-page content-lh">
	<div class="u-bread">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="unica-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="."><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
                            <li class="breadcrumb-item active">
                                <?php echo $this->lang->line('contact') ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="content-page content-lienhe">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-9 col-xs-12">
                	<div class="wp-right-gt wp-llih-right">
                        <div class="contnet-lienhe">
                            <div class="wp-left-lh">
                            	<p>Cám ơn quý khách đã ghé thăm website chúng tôi.</p>
                                <h4 class="ff-tib"><?php echo $this->fcSystem['homepage_company'] ?></h4>
                                <ul>
                                    <li><b>Địa chỉ: </b> <?php echo $this->fcSystem['contact_address'] ?></li>
                                    <li><b>Điện thoại: </b> <?php echo $this->fcSystem['contact_phone'] ?></li>
                                    <li><b>Email: </b><?php echo $this->fcSystem['contact_email'] ?></li>
                                    <li><b>Website: </b><?php echo $this->fcSystem['contact_web'] ?></li>
                                </ul>
                                <div class="map-lh">
                                    <?php echo $this->fcSystem['contact_map'] ?>
									<style>.map-lh iframe {width: 100%;height: 100%; min-height: 300px;}</style>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="wp-right-lh">
                        <p>Mời bạn điền vào mẫu thư liên lạc và gửi đi cho chúng tôi. Các chuyên viên tư vấn của chúng tôi sẽ trả lời bạn trong thời gian sớm nhất.</p>
                        <div class="fr-tt-lh">
                        	<?php $error = validation_errors(); echo !empty($error) ? '<div class="callout callout-danger" style="padding:10px;background:rgb(195, 94, 94);color:#fff;margin-bottom:10px;">'.$error.'</div>' : '';?>
                            <form action="" method="post" >
                                <input class="form-control" type="text" name="fullname" placeholder="Họ và tên *">
                                <input class="form-control" type="text" name="email" placeholder="Email *">
                                <input class="form-control" type="text" name="phone" placeholder="Điện thoại *">
                                <input class="form-control" type="text" name="title" placeholder="Tiêu đề thư *">
                                <textarea class="form-control" name="message" placeholder="Nội dung *" rows="8"></textarea>
                                <input class="btn btn-primary" type="submit" name="create" value="Gửi đi" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>