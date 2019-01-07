<?php
class ManageDashboard
{
	function getMyDashboard()
	{
		return $this->CompanyDashboard();
	}
	function CompanyDashboard()
	{
		global $wpdb;
		$user_id = get_current_user_id();
		$enc['id']=$user_id;
		$data=json_encode($enc);
		$dataenc=CabEncrypt($data);
		
		$arr=array();
		if($_REQUEST['action']=="vehicle"):
			$vinfo=new Vehicleinfo();
			$data1=$vinfo->display();			
		endif;		
		if($_REQUEST['action']=="drivers"):
			$vinfo=new Driversinfo();
			$data1=$vinfo->display();			
		endif;
		if($_REQUEST['action']=="pricing"):
			$vinfo=new Pricinginfo();
			$data1=$vinfo->display();			
		endif;
		if($_REQUEST['action']=="bookings"):
			$vinfo=new Bookingsinfo();
			$data1=$vinfo->display();			
		endif;
		
		$arr['Bookings']=get_bloginfo('url')."/cabbooking/?action=bookings";
		$arr['Jobs']=get_bloginfo('url')."/cabbooking/?action=jobs";
		$arr['Company']=get_bloginfo('url')."/cabbooking/?action=company";
		$arr['Reservation']=get_bloginfo('url')."/book_here/?ka=".$dataenc."#step-1";
		$arr['Vehicle']=get_bloginfo('url')."/cabbooking/?action=vehicle";
		$arr['Drivers']=get_bloginfo('url')."/cabbooking/?action=drivers";
		$arr['Pricing']=get_bloginfo('url')."/cabbooking/?action=pricing";
		
		
		$menu=new ManageMenuinfo();
		$data2=$menu->display($arr);
		
		
		$data3='<div class="row"><div class="col-sm-12">&nbsp;</div></div>';
		$data3.='<div class="row"><div class="col-sm-1">&nbsp;</div><div class="col-sm-10">';
		$data3.=$data1.$menu->ModalBox();
		$data3.='</div><div class="col-sm-1">&nbsp;</div></div>';
		
		$data='<div class="row dashbord"><div class="col-sm-12">'.$data2.$data3.'</div></div>';		
		return $data;
	}
}