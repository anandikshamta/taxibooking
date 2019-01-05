<?php
class Vehicleinfo
{
	function display()
	{
		if($_POST['operation']=="create"):
			$this->CreateIT();exit;
		elseif($_POST['operation']=="delete"):
			$this->DeleteProcess();exit;	
		else:
			ob_start();
			if($_POST['createfrm']=="1"):$this->InsertProcess();endif;
			$this->ListIT();
			$display=ob_get_clean();
			return $display;
		endif;	
	}
	function ListIT()
	{
		global $wpdb;
		$user_id = get_current_user_id();
		$query="select * from wp_cab_vehicle where company_id=".$user_id." Order by id desc";
		$result=$wpdb->get_results($query);
		?>
		<script type="text/javascript" src="<?php echo plugins_url();?>/cab_booking/inc/js/vehicle.js"></script>
		<div class="row">
			<div class="col-sm-11 msgdisplay"></div>
		</div>
		<table class="table table-striped table-bordered table-hover table-responsive no-footer dataTable">
			<thead><tr>
				<th>Plate</th>
				<th>Brand</th>
				<th>Model</th>
				<th>Color</th>
				<th>Seats</th>
				<th>Luggage</th>
				<th>Available</th>
				<th>PCO L.N</th>
				<th>PCO exp.Date</th>
				<th>MOT</th>
				<th>Ins Exp.Date</th>
				<th>Reg.number</th>
				<th>Action</th>
			</tr>
			</thead>
			<?php 
				$k=1;
				foreach($result as $rs):
					if($rs->available=="1"): $available="Yes";else: $available="No"; endif;
					echo '<tr>';
						//echo '<td>'.$k.'</td>';
						echo '<td>'.$rs->plate.'</td>';
						echo '<td>'.$rs->brand.'</td>';
						echo '<td>'.$rs->model.'</td>';
						echo '<td>'.$rs->color.'</td>';
						echo '<td>'.$rs->seats.'</td>';
						echo '<td>'.$rs->luggage.'</td>';
						echo '<td>'.$available.'</td>';
						echo '<td>'.$rs->pco_ln.'</td>';
						echo '<td>'.date("m/d/Y",strtotime($rs->pco_exp_date)).'</td>';
						echo '<td>'.$rs->mot.'</td>';
						echo '<td>'.date("m/d/Y",strtotime($rs->ins_exp_date)).'</td>';
						echo '<td>'.$rs->reg_number.'</td>';
						echo '<td><a href="javascript:;" data-id="'.$rs->id.'" class="editit"><i class="fa fa-edit editcls"></i></a>&nbsp;&nbsp;<a href="javascript:;" class="deleteit" data-id="'.$rs->id.'"><i class="fa fa-trash trashcls"></i></a></td>';
					echo '</tr>';
					$k++;
				endforeach;
			?>
			<tbody>
			
			</tbody>
		</table>
		<?php
		
	}
	function InsertProcess()
	{
		global $wpdb;
		$user_id = get_current_user_id();
		$param=json_decode(json_encode($_POST))                                                      ;
		$created_at=date('Y-m-d H:i:s');
		$param->pco_exp_date=date('Y-m-d H:i:s',strtotime($param->pco_exp_date));
		$param->ins_exp_date=date('Y-m-d H:i:s',strtotime($param->ins_exp_date));
		
		if($param->did):
			$query="update `wp_cab_vehicle` set `plate`='".$param->plate."',`brand`='".$param->brand."',`model`='".$param->model."',`color`='".$param->color."',`seats`='".$param->seats."',`luggage`='".$param->luggage."',`available`='".$param->available."',`pco_ln`='".$param->pco_ln."',`pco_exp_date`='".$param->pco_exp_date."',`mot`='".$param->mot."',`ins_exp_date`='".$param->ins_exp_date."',`reg_number`='".$param->reg_number."',`modified_at`='".$created_at."' where id=".$param->did;
			$wpdb->query($query);
			$msg="Vehicle updated successfully";
		else:
			$query="insert into `wp_cab_vehicle`(`company_id`,`plate`,`brand`,`model`,`color`,`seats`,`luggage`,`available`,`pco_ln`,`pco_exp_date`,`mot`,`ins_exp_date`,`reg_number`,`created_at`) values
					('".$user_id."','".$param->plate."','".$param->brand."','".$param->model."','".$param->color."','".$param->seats."','".$param->luggage."','".$param->available."','".$param->pco_ln."','".$param->pco_exp_date."','".$param->mot."','".$param->ins_exp_date."','".$param->reg_number."','".$created_at."')";
			$wpdb->query($query);
			$msg="Vehicle created successfully";
		endif;
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>'.$msg.'</div>';
	}
	function DeleteProcess()
	{
		global $wpdb;
		$did=$_POST['id'];
		$query="delete from `wp_cab_vehicle` where id=".$did;
		$wpdb->query($query);
		$msg="Vehicle deleted successfully";
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>'.$msg.'</div>';
		exit;
	}
	function CreateIT()
	{
		if($_POST['id']):
			global $wpdb;
			$did=$_POST['id'];
			$user_id = get_current_user_id();
			$query="select * from wp_cab_vehicle where id=".$did;
			$result=$wpdb->get_results($query);		
			$rs=$result[0];	
		endif;
		?>
		<form name="frm" id="frm">
			<div class="row">
				<div class="col-sm-11 populatemessage"></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Plate<span class="md">*</span></label>
						<input type="text" class="form-control" name="plate" id="plate" value="<?php echo $rs->plate; ?>">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Brand<span class="md">*</span></label>
						<input type="text" class="form-control" name="brand" id="brand" value="<?php echo $rs->brand; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Model<span class="md">*</span></label>
						<input type="text" class="form-control" name="model" id="model" value="<?php echo $rs->model; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Color<span class="md">*</span></label>
						<input type="text" class="form-control" name="color" id="color" value="<?php echo $rs->color; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Seats<span class="md">*</span></label>
						<input type="text" class="form-control" name="seats" id="seats" value="<?php echo $rs->seats; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Luggage<span class="md">*</span></label>
						<input type="text" class="form-control" name="luggage" id="luggage" value="<?php echo $rs->luggage; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Available<span class="md">*</span></label>
						<?php
						if($rs->available=="1"): $chk='checked="checked"';else: $chk=''; endif;
						?>
						<input type="checkbox" name="available" id="available" value="1" <?php echo $chk;?>>								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>PCO L.N<span class="md">*</span></label>
						<input type="text" class="form-control" name="pco_ln" id="pco_ln" value="<?php echo $rs->pco_ln; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>PCO exp.Date<span class="md">*</span></label>
						<input type="text" class="form-control datepicker" name="pco_exp_date" id="pco_exp_date" value="<?php echo date("m/d/Y",strtotime($rs->pco_exp_date)); ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>MOT<span class="md">*</span></label>
						<input type="text" class="form-control" name="mot" id="mot" value="<?php echo $rs->mot; ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Ins Exp.Date<span class="md">*</span></label>
						<input type="text" class="form-control datepicker" name="ins_exp_date" id="ins_exp_date" value="<?php echo date("m/d/Y",strtotime($rs->ins_exp_date)); ?>">								
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Reg.number<span class="md">*</span></label>
						<input type="text" class="form-control" name="reg_number" id="reg_number" value="<?php echo $rs->reg_number; ?>">								
					</div>
				</div>
			</div>
			
			
			
			
			<div class="row">
				<div class="col-lg-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group text-center">
						<input type="hidden" name="createfrm" value="1">
						<input type="hidden" name="did" value="<?php echo $did; ?>">
						<button type="button" name="process_data" class="btn btn-primary process_data" value="Submit">Submit</button>
						<button type="button" name="search_reset" class="btn btn-primary btn-reset" value="Reset">Reset</button>
					</div>
				</div>
			</div>
		</form>
		<?php
	}
	
}