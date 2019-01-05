<?php
class BookHere
{
	function BookCab()
	{
		if($_POST['signstep']=="1"):
			$this->RegisterStep1();
		else:
			$b=new BookHereForm();
			echo $b->BookhereHtml();exit;
		endif;
	}
	function RegisterStep1()
	{
		global $wpdb;
		$arr=array();
		$param=$_POST['frmdata'];
		$company=json_decode(CabDecrypt($_POST['ka']));		
		$company_id=$company->id;
		$pickup_date=date("Y-m-d H:i:s",strtotime($param['pickup_date']." ".$param['pickup_date_hours'].":".$param['pickup_date_mins']));
		$return_date=date("Y-m-d H:i:s",strtotime($param['return_date']." ".$param['return_date_hours'].":".$param['return_date_mins']));
		$created_at=date("Y-m-d H:i:s");
		
		$insquery="insert into `wp_cab_booking`(`company_id`,`from_address`,`to_address`,`extra`,`passenger`,`luggage`,`way`,`pickup_date`,`return_date`,`meet_greet`,`baby_seat`,`booster`,`wheelcair`,`created_date`) values 
					('".$company_id."','".$param['from']."','".$param['to']."','".$param['extra']."','".$param['passengers']."','".$param['way']."','".$pickup_date."','".$return_date."','".$param['meet_greet']."','".$param['baby_seat']."','".$param['booster_seat']."','".$param['wheel_chair']."','".$param['promo_code']."','".$created_at."')";
					
		$wpdb->query($insquery);	
		$insert_id=$wpdb->insert_id;
		$arr['id']=$company_id;
		$arr['book_id']=$insert_id;		
		$data=json_encode($arr);
		$dataenc=CabEncrypt($data);		
		echo "1##########".$dataenc;exit;
	}
}
?>