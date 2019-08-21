 <div class="col-md-3">
         <a href="<?php echo site_url('contacts/backend/home/compose'); ?>" class="btn btn-danger btn-block margin-bottom">Compose</a>
         <div class="box box-solid">
            <div class="box-header with-border">
               <h3 class="box-title">Folders</h3>
               <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
               </div>
            </div>
			<?php 
				$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			?>
            <div class="box-body no-padding">
               <ul class="nav nav-pills nav-stacked">
                  <li class="<?php echo  ($actual_link == site_url('contacts/backend/home/view')) ? 'active' : '' ?>"><a href="<?php echo site_url('contacts/backend/home/view'); ?>"><i class="fa fa-inbox"></i> Inbox
                     <span class="label label-danger pull-right"><?php echo $this->Autoload_Model->_public_count('contacts', array('where' => array('read' => 0))); ?></span></a>
                  </li>
                  <li class="<?php echo  ($actual_link == site_url('contacts/backend/home/trash')) ? 'active' : '' ?>"><a href="<?php echo site_url('contacts/backend/home/trash'); ?>"><i class="fa fa-trash-o"></i> Trash<span class="label label-primary pull-right"><?php echo $this->Autoload_Model->_public_count('contacts', array('where' => array('trash' => 1)), TRUE); ?></span></a></li>
               </ul>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /. box -->
      </div>