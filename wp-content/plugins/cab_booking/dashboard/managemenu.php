<?php
class ManageMenuinfo
{
	function display($arr)
	{
		ob_start();
		$this->ListMenu($arr);
		$display=ob_get_clean();
		return $display;
	}
	function ModalBox()
	{
		ob_start();
		$this->ModalHtml();
		$display=ob_get_clean();
		return $display;
	}
	function ListMenu($arr)
	{
		
		?>
		<link rel="stylesheet" href="<?php echo plugins_url();?>/cab_booking/inc/css/jquery.dataTables.min.css" >
		<link rel="stylesheet" href="<?php echo plugins_url();?>/cab_booking/inc/css/jquery-ui.css" >
		<script type="text/javascript" src="<?php echo plugins_url();?>/cab_booking/inc/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="<?php echo plugins_url();?>/cab_booking/inc/js/jquery-ui.js"></script>
		
		<div id="sticker" class="header-area" >
      <div class="">
        <div class="row">
          <div class="col-md-12 col-sm-12">

            <!-- Navigation -->
            <nav class="navbar navbar-default">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
                <!-- Brand -->
                
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
					<ul id="menu-topmenu" class="nav navbar-nav navbar-left">
						<?php
						foreach($arr as $k=>$v):
							echo '<li><a href="'.$v.'">'.$k.'</a></li>';
						endforeach
						?>
					</ul>
                
				
              </div>
              <!-- navbar-collapse -->
            </nav>
            <!-- END: Navigation -->
          </div>
        </div>
      </div>
    </div>
		<?php
		
	}
	function ModalHtml()
	{
		?>
		<div id="popupbox" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Modal Header</h4>
			  </div>
			  <div class="modal-body">
				<p>Some text in the modal.</p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		<?php
	}
	

}