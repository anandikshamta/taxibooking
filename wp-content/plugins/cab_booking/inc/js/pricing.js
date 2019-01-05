$(document).ready( function () {
	$('.dataTable').DataTable();
	$(document).on('click', ".process_data", function (){ 	
		var frmdata=$('form#frm').serializeArray(); 
		obj = {};
		$(frmdata).each(function(i, field){
			obj[field.name] = field.value;
		});
		VCL.Validate(obj);
	});
	$(document).on('click', ".editit", function (){ 
		var id=$(this).data("id");
		VCL.EditProcess(id);
		
	});
	$(document).on('click', ".deleteit", function (){ 	
		var id=$(this).data("id");		
		VCL.DeleteProcess(id);
	});
	$(document).on('click', ".setpricing", function (){ 	
		var id=$(this).data("id");		
		VCL.MetaProcess(id);
	});
	
	var max_fields      = 10; //maximum input boxes allowed
	var x = 1; //initlal text box count
	$(document).on('click', ".add_radius", function (){ 	
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			var wraphtml='<tr><td><input type="text" class="form-control" name="radius_upto_distance_'+x+'" id="radius_upto_distance_'+x+'" value="0"></td><td><input type="text" class="form-control" name="radius_one_way_price_'+x+'" id="radius_one_way_price_'+x+'" value="0"></td><td><input type="text" class="form-control" name="radius_return_price_'+x+'" id="radius_return_price_'+x+'" value="0"></td><td><a href="javascript:;" class="radius_remove"><i class="fa fa-trash trashcls"></i></a></td></tr>';
			$('.add_radius_fields_wrap').append(wraphtml); //add input box
		}
	});	
	$(document).on("click",".radius_remove", function(e){ //user click on remove text
		$(this).closest('tr').remove(); x--;
	})
	
	$(document).on('click', ".add_hourly_price", function (){ 	
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			var wraphtml='<tr><td><input type="text" class="form-control" name="hourly_hour_'+x+'" id="radius_upto_distance_'+x+'" value="0"></td><td><input type="text" class="form-control" name="hourly_price_'+x+'" id="radius_one_way_price_'+x+'" value="0"></td><td><a href="javascript:;" class="hourly_remove"><i class="fa fa-trash trashcls"></i></a></td></tr>';
			$('.add_hourly_fields_wrap').append(wraphtml); //add input box
		}
	});	
	$(document).on("click",".hourly_remove", function(e){ //user click on remove text
		$(this).closest('tr').remove(); x--;
	})
	
	
});

VCL={
	CreateProcess:function()
	{
		$('#popupbox').modal();
		$('.modal-title').html('Add Vechicles');
		$('.modal-body').html('<div class="loading-icon text-center"><i class="fa fa-spinner fa-spin loader" ></i></div>');
		
		var base_url=$('#base_url').val();
		var url = base_url+'/cabbooking/?action=pricing';
		$.ajax({
			url:url,
			type:'POST',
			data: {	
				operation:'create'
			},
			success: function(result) { 
				$('.modal-body').html(result);
				$( ".datepicker" ).datepicker();	
			}
		});
	},
	EditProcess:function(id)
	{
		$('#popupbox').modal();
		$('.modal-title').html('Edit Vechicles');
		$('.modal-body').html('<div class="loading-icon text-center"><i class="fa fa-spinner fa-spin loader" ></i></div>');
		
		var base_url=$('#base_url').val();
		var url = base_url+'/cabbooking/?action=pricing';
		$.ajax({
			url:url,
			type:'POST',
			data: {	
				operation:'create',
				id:id
			},
			success: function(result) { 
				$('.modal-body').html(result);
				$( ".datepicker" ).datepicker();	
			}
		});
	},
	MetaProcess:function(id)
	{
		$('#popupbox').modal();
		$('.modal-title').html('Edit Vechicles');
		$('.modal-body').html('<div class="loading-icon text-center"><i class="fa fa-spinner fa-spin loader" ></i></div>');
		$('.modal-dialog').css({"width":"70%"});
		
		var base_url=$('#base_url').val();
		var url = base_url+'/cabbooking/?action=pricing';
		$.ajax({
			url:url,
			type:'POST',
			data: {	
				operation:'meta_process',
				id:id
			},
			success: function(result) { 
				$('.modal-body').html(result);
				$( ".datepicker" ).datepicker();	
			}
		});
	},
	DeleteProcess:function(id)
	{
		if(confirm("Are you sure you want to delete?"))
		{	
			$('.alert').remove();
			var base_url=$('#base_url').val();
			var url = base_url+'/cabbooking/?action=pricing';
			$.ajax({
				url:url,
				type:'POST',
				data: {	
					operation:'delete',
					id:id
				},
				success: function(result) { 
					$('.msgdisplay').html(result);
				}
			});
		}
	},
	Validate:function(obj)
	{
		var popup_error='<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
		var popup_error_close='</div>';
		if(obj.plate=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your plate'+popup_error_close);
			$('#plate').focus();
		}
		else if(obj.brand=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your brand'+popup_error_close);
			$('#brand').focus();
		}
		else if(obj.model=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your model'+popup_error_close);
			$('#model').focus();
		}
		else if(obj.color=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your color'+popup_error_close);
			$('#color').focus();
		}
		else if(obj.seats=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your seats'+popup_error_close);
			$('#seats').focus();
		}
		else if(obj.luggage=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your luggage'+popup_error_close);
			$('#luggage').focus();
		}
		else if(obj.available=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your available'+popup_error_close);
			$('#available').focus();
		}
		else if(obj.pco_ln=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your PCO L.N'+popup_error_close);
			$('#pco_ln').focus();
		}
		else if(obj.pco_exp_date=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your PCO Expiry date'+popup_error_close);
			$('#pco_exp_date').focus();
		}
		else if(obj.pco_ln=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your PCO L.N'+popup_error_close);
			$('#pco_ln').focus();
		}
		else if(obj.mot=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your mot'+popup_error_close);
			$('#mot').focus();
		}
		else if(obj.ins_exp_date=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your INS Expiry date'+popup_error_close);
			$('#ins_exp_date').focus();
		}
		else if(obj.reg_number=="")
		{
			$('.populatemessage').html(popup_error+'Please enter your registration number'+popup_error_close);
			$('#reg_number').focus();
		}
		else
		{
			document.frm.action="";
			document.frm.method="POST";
			document.frm.submit();
		}
	}
};