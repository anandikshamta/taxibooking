$(document).ready( function () {
	$('.dataTable').DataTable();
	var wp_url = $('#wp_url').val();
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
	$(document).on('click', ".setpricing", function() {
		var id=$(this).data("id");
		VCL.MetaProcess(id);
	});
	var max_fields = 10; //maximum input boxes allowed
	var x = 1; //initlal text box count
	/*$(document).on('click', ".add_radius", function() {
		if(x < max_fields) { //max input box allowed
			x++; //text box increment
			var wraphtml = '<tr>' +
			'<td><input type="text" class="form-control" name="radius_upto_distance_'+x+'" id="radius_upto_distance_'+x+'" value="0"></td>'+
			'<td><input type="text" class="form-control" name="radius_one_way_price_'+x+'" id="radius_one_way_price_'+x+'" value="0"></td><td><input type="text" class="form-control" name="radius_return_price_'+x+'" id="radius_return_price_'+x+'" value="0"></td>'+
			'<td><a href="javascript:void(0);" class="radius_remove"><i class="fa fa-trash trashcls"></i></a></td>'+
			'</tr>';
			$('.add_radius_fields_wrap').append(wraphtml); //add input box
		}
	});
	$(document).on("click", ".radius_remove", function(e){ //user click on remove text
		$(this).closest('tr').remove();
		x--;
	})*/

	/*$(document).on('click', ".add_hourly_price", function() {
		if(x < max_fields) { //max input box allowed
			x++; //text box increment
			var wraphtml = '<tr>'+
			'<td><input type="text" class="form-control" name="hourly_hour_'+x+'" id="radius_upto_distance_'+x+'" value="0"></td>'+
			'<td><input type="text" class="form-control" name="hourly_price_'+x+'" id="radius_one_way_price_'+x+'" value="0"></td>'+
			'<td><a href="javascript:void(0);" class="hourly_remove"><i class="fa fa-trash trashcls"></i></a></td>'+
			'</tr>';
			$('.add_hourly_fields_wrap').append(wraphtml); //add input box
		}
	});*/

/*	$('#my-table').Tabledit({

		url: wp_url+'?action=pricing.php',
		editmethod: 'post',
  		deletemethod: 'post',

  		// Class for form inputs
  		inputClass: 'form-control input-sm',

  		// Localization -(en, default) - LowerCase or UpperCase

		lang: 'en',

		// Debug mode
		debug: false,

  		// Trigger to change for edit mode
  		eventType: 'click',
  		editButton: true,
  		deleteButton: true,
  		saveButton: true,

  		buttons: {
			edit: {
				class: 'btn btn-sm btn-default',
				html: '<span class="glyphicon glyphicon-pencil"></span>',
				action: 'edit'
	    	},
		    delete: {
		      class: 'btn btn-sm btn-default',
		      html: '<span class="glyphicon glyphicon-trash"></span>',
		      action: 'delete'
		    },
		    save: {
		      class: 'btn btn-sm btn-success',
		      html: ''
		    },
			restore: {
			  class: 'btn btn-sm btn-warning',
			  html: 'Restore',
			  action: 'restore'
			},
		    confirm: {
				class: 'btn btn-sm btn-danger',
				html: 'Confirm'
		    }
	  	},
	  	onDraw: function () {
			return;
	  	},
	  	// Executed when the ajax request is completed
		onSuccess: function () {
			return;
		},

	  	// Executed when occurred an error on ajax request
		onFail: function () {
	    	return;
		},

		// Executed whenever there is an ajax request
		onAlways: function () {
	    	return;
	  	},
	 	// Executed before the ajax request
	  	onAjax: function () {
	    	return;
	  	},
		columns: {
			identifier: [0, 'id'],
			editable: [[1, 'col1'], [2, 'col1'], [3, 'col3']]
		},
	});
*/
	$(document).on("click", ".hourly_remove", function(e){ //user click on remove text
		$(this).closest('tr').remove();
		x--;
	})



});

VCL={
	CreateProcess:function()
	{
		$('#popupbox').modal();
		$('.modal-title').html('Add Pricing');
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
		$('.modal-title').html('Edit Pricing');
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
		$('.modal-title').html('Edit Pricing');
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
				loadRadiusGrid();
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
			//document.frm.action="/cabbooking/?action=pricing";
			document.frm.action="";
			document.frm.method="POST";
			document.frm.submit();
		}
	}
};


function loadRadiusGrid() {
	var wp_url = $('#wp_url').val();
	wp_url = wp_url + '/cabbooking/';
	$("#radiusGrid").jsGrid({
        height: "30%",
        width: "100%",
        filtering: false,
        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 8,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete ?",
        controller: {
            loadData: function(filter) {
console.log(wp_url);
            	console.log('loadRadius');
                return $.ajax({
                    type: "GET",
                    url: wp_url + "?action=pricing&do_action=crud_radius",
                    data: filter
                });
                //return data;
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: wp_url + "?action=pricing&do_action=crud_radius",
                    data: item
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: wp_url + "?action=pricing&do_action=crud_radius",
                    data: item
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: wp_url + "?action=pricing&do_action=crud_radius",
                    data: item
                });
            }
        },
        fields: [
        	{ name: "id", title: "Id", type: "number", css: "hide", width: 10 },
            { name: "upto_distance", title: "Up to Distance", type: "text", width: 50 },
            { name: "oneway_price", title: "One way Price", type: "text", width: 50, filtering: false },
            { name: "return_price", title: "Return Price", type: "text", width: 50, filtering: false },
            { type: "control" }
        ]
    });
}