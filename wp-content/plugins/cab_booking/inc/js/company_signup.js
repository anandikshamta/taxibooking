
$(document).ready(function(){
	$(document).on('click', ".signuphere", function (){ 		
        CSIGN.GetForm();
    });
	$(document).on('click', ".btn-signup", function (){ 		
        CSIGN.Signup();
    });	
	$(document).on('click', ".btn-reset", function (){ 		
        $('form#frm').trigger("reset");
    });
	$(document).on('click', ".close", function (){ 		
        $('.alert').remove();
    });
	
});	
	
CSIGN={
	ProcessSignUP:function()
	{
		var obj=CSIGN.FormData(); 
		$('.pricetag').hide();
		$('.regform').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		var error='<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
		var error_close='</div>';
		
		var base_url=$('#base_url').val();
		var url = base_url+'/company_signup';
		$.ajax({
			url:url,
			type:'POST',
			data: {	
				process_sign:1,
				ajaxcall:1,
				frmdata:obj
			},
			success: function(result) { 
				$('.regform').html(error+result+error_close);			
			}
			
		});
	},
	Signup:function()
	{
		var obj=CSIGN.FormData(); 
		var error='<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>';
		var error_close='</div>';
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		 
		if(obj.email=="")
		{
			$('.populatemessage').html(error+'Please enter your email id'+error_close)
			$('#email').focus();
		}
		else if (!filter.test(obj.email)) 
		{
			$('.populatemessage').html(error+'Please enter your valid email id'+error_close)
			$('#email').focus();
		}
		else if(obj.pass=="")
		{
			$('.populatemessage').html(error+'Please enter your passowrd'+error_close)
			$('#pass').focus();
		}
		else if(obj.cpass=="")
		{
			$('.populatemessage').html(error+'Please enter your confirm password'+error_close)
			$('#cpass').focus();
		}
		else if(obj.cpass!==obj.pass)
		{
			$('.populatemessage').html(error+'Password and confirm password should be same'+error_close)
			$('#cpass').focus();
		}
		else if(obj.cname=="")
		{
			$('.populatemessage').html(error+'Please enter your company name'+error_close)
			$('#cname').focus();
		}
		else if(obj.website=="")
		{
			$('.populatemessage').html(error+'Please enter your company website'+error_close)
			$('#website').focus();
		}
		else if(obj.fname=="")
		{
			$('.populatemessage').html(error+'Please enter your first name'+error_close)
			$('#fname').focus();
		}
		else if(obj.lname=="")
		{
			$('.populatemessage').html(error+'Please enter your last name'+error_close)
			$('#lname').focus();
		}
		else if(obj.phone=="")
		{
			$('.populatemessage').html(error+'Please enter your phone number'+error_close)
			$('#phone').focus();
		}
		else if(obj.country=="")
		{
			$('.populatemessage').html(error+'Please enter your country'+error_close)
			$('#country').focus();
		}
		else
		{
			CSIGN.ProcessSignUP();
		}
	},
	FormData:function()
	{
		var frmdata=$('form#frm').serializeArray(); 
		obj = {};
		$(frmdata).each(function(i, field){
			obj[field.name] = field.value;
		});
		return obj;
	},
	GetForm:function()
	{
		$('.pricetag').hide();
		$('.regform').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
		
		var base_url=$('#base_url').val();
		var url = base_url+'/company_signup';
		$.ajax({
			url:url,
			type:'POST',
			data: {	
				signup:1,
				ajaxcall:1
			},
			success: function(result) { 
				$('.regform').html(result);		
				$('.regform').addClass('card cardbox');				
			}
			
		});
	}
};	