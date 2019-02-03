<?php
class Bookingsinfo
{
	function display()
	{
		if($_POST['operation']=="create"):
			$this->CreateIT();exit;
		elseif($_POST['operation']=="delete"):
			$this->DeleteProcess();exit;
		else:
			ob_start();
			//if($_POST['createfrm']=="1"):$this->InsertProcess();endif;
			$this->ListIT();
			$display = ob_get_clean();
			return $display;
		endif;
	}
	function ListIT()
	{
		global $wpdb;
		$user_id = get_current_user_id();
		$query = "select * from wp_cab_bookings where 1 Order by id desc";
		$result = $wpdb->get_results($query);
		?>
		<script type="text/javascript" src="<?php echo plugins_url();?>/cab_booking/inc/js/drivers.js"></script>
		<div class="row">
			<div class="col-sm-11 msgdisplay"></div>
		</div>

		<?php

	}
	function InsertProcess()
	{
		global $wpdb;

	}
	function DeleteProcess()
	{
		global $wpdb;
		$did=$_POST['id'];
		$query="delete from `wp_cab_drivers` where id=".$did;
		$wpdb->query($query);
		$msg="Drivers deleted successfully";
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>'.$msg.'</div>';
		exit;
	}
	function CreateIT()
	{
		global $wpdb;

		?>

		<?php
	}

}