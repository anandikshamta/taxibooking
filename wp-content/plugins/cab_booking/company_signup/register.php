<?php
class RegisterHtml
{
	function RegisterHtml()
	{
		ob_start();
		?>
		<script src="<?php echo plugins_url();?>/cab_booking/inc/js/company_signup.js"></script>
		<div class="container">
			<div class="row pricetag">
				<div class="col col-lg-2">&nbsp;</div>
				<div class="col col-lg-8">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								  <ul class="price">
									<li class="header">Free Trial</li>
									<li class="grey">Free Trial</li>
									<li>7 days</li>
									<li>Full Access</li>
									<li>Transaction not applicable</li>
									<li class="grey"><a href="javascript:;" class="button signuphere">Sign Up</a></li>
								  </ul>						
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								  <ul class="price">
									<li class="header" style="background-color:#4CAF50">Premium</li>
									<li class="grey">$ 99.99 / year</li>
									<li>1 Year</li>
									<li>Full Access</li>
									<li>Transaction not applicable</li>
									<li class="grey"><a href="javascript:;" class="button signuphere">Sign Up</a></li>
								  </ul>						
							</div>
						</div>
					</div>
				</div>
				
				<div class="col col-lg-2">&nbsp;</div>
			</div>
		  
			<div class="row">
				<div class="col col-lg-3">&nbsp;</div>
				<div class="col col-lg-6 regform">&nbsp;</div>
				<div class="col col-lg-3">&nbsp;</div>
			</div>
		  
		</div>
		
		<?php
		return ob_get_clean();
	}
	function SignupFree()
	{
		?>
		<form name="frm" id="frm">
			<div class="row">
				<div class="col-sm-11 populatemessage"></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Email<span class="md">*</span></label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Enter your email">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Password<span class="md">*</span></label>
						<input type="password" class="form-control" name="pass" id="pass">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Confirm Password<span class="md">*</span></label>
						<input type="password" class="form-control" name="cpass" id="cpass">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">&nbsp;</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Company name<span class="md">*</span></label>
						<input type="text" class="form-control" name="cname" id="cname" placeholder="Enter your company name">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Company Website<span class="md">*</span></label>
						<input type="text" class="form-control" name="website" id="website" placeholder="Enter your company website">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Firstname<span class="md">*</span></label>
						<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter your Firstname">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Lastname<span class="md">*</span></label>
						<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter your Lastname">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Phone<span class="md">*</span></label>
						<input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Country<span class="md">*</span></label>
						<input type="text" class="form-control" name="country" id="country" placeholder="Enter your country">								
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">&nbsp;</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group text-center">
						<button type="button" name="load_ip_details" class="btn btn-primary btn-signup" value="Submit">Submit</button>
						<button type="button" name="search_reset" class="btn btn-primary btn-reset" value="Reset">Reset</button>
					</div>
				</div>
			</div>
		</form>
		<?php
		exit;
	}
	function SignupCompany()
	{
		global $wpdb;
		$param=$_POST['frmdata'];
		$email=$param['email'];
        $display_name=$param['fname']." ".$param['lname'];
        $setrole='companyadmin';
        
        if( null == username_exists( $email ) ):
            $password = $param['pass'];
            $user_id = wp_create_user( $email, $password, $email );
            wp_update_user(
              array(
                'ID'          =>    $user_id,
                'nickname'    =>    $display_name,
                'role'        =>    $setrole
              )
            );
            $wpdb->query("update wp_users set display_name='".$display_name."' where ID=".$user_id);
            wp_mail( $email, 'Welcome to our Application!', 'Please signup  ' . $password );
			
			$rightnow = date('Y-m-d h:i:s');
			$add7days = date('Y-m-d h:i:s', strtotime('+7 days'));
			
			$insquery="insert into `wp_cab_company_payment`(`user_id`,`account_type`,`transaction_status`,`start_date`,`end_date`) values ('".$user_id."','trial','completed','".$rightnow."','".$add7days."')";
			$wpdb->query($insquery);
            echo 'Company account created successfully';exit;
		endif;
		 
	}
}
class CompanySignup extends RegisterHtml
{
	function Register()
	{
		if($_POST['signup']=="1")://Free Trial
			return $this->SignupFree();
		elseif($_POST['process_sign']=="1")://Free Trial
			return $this->SignupCompany();
		else:
			return $this->RegisterHtml();
		endif;	
	}
}
?>