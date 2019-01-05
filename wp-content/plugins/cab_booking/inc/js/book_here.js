  $(document).ready(function(){
			$( ".datepicker" ).datepicker();			
			// Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish').addClass('btn btn-info btn-finish').on('click', function(){ Book.FinishedClk(); });

            // Smart Wizard
            $('#smartwizard').
			smartWizard({
						selected: 0,
						theme: 'arrows',
						transitionEffect:'fade',
						cycleSteps: false, 
						toolbarSettings: {
							toolbarPosition: 'both',
							  toolbarButtonPosition: 'end',
							  toolbarExtraButtons: [btnFinish],
							  showPreviousButton:false
							},
						anchorSettings: {
							anchorClickable: false,
						}
            });
			
			$(".btn-finish").hide();
			Book.StepsValidate();
            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) { 
				Book.NextProcess(e, anchorObject, stepNumber,stepDirection, stepPosition);
            });
			
			$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
				var error='<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>'; 
				var error_close='</div>';
				stepNumber=stepNumber+1; 
                if(stepNumber=="1"){
					var obj=Book.FormData('frm_step1');
					console.log(obj);
					if(obj.from=="")
					{
						$('.step1error').html(error+'Please enter your from address'+error_close)
						$('#from').focus();
						return false;
					}
					else if(obj.to=="")
					{
						$('.step1error').html(error+'Please enter your to address'+error_close)
						$('#to').focus();
						return false;
					}
					else if(obj.pickup_date=="")
					{
						$('.step1error').html(error+'Please enter your pickup date'+error_close)
						$('#pickup_date').focus();
						return false;
					}
					else if(obj.pickup_date_hours=="0")
					{
						$('.step1error').html(error+'Please enter your pickup date hours'+error_close)
						$('#pickup_date_hours').focus();
						return false;
					}
					else if(obj.pickup_date_mins=="0")
					{
						$('.step1error').html(error+'Please enter your pickup date mins'+error_close)
						$('#pickup_date_mins').focus();
						return false;
					}
					else if((obj.way=="2")&&(obj.return_date==""))
					{
						$('.step1error').html(error+'Please enter your return date'+error_close)
						$('#return_date').focus();
						return false;
					}
					else if((obj.way=="2")&&(obj.return_date_hours=="0"))
					{
						$('.step1error').html(error+'Please enter your pickup return date hours'+error_close)
						$('#return_date_hours').focus();
						return false;
					}
					else if((obj.way=="2")&&(obj.return_date_mins=="0"))
					{
						$('.step1error').html(error+'Please enter your return date mins'+error_close)
						$('#return_date_mins').focus();
						return false;
					}
					else
					{
						$('.step1detail').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
						
						var base_url=$('#base_url_pop').val();
						var ka=$('#ka').val();
						
						var url = base_url+'/book_here';
						$.ajax({
							url:url,
							type:'POST',
							data: {	
								signstep:1,
								ajaxcall:1,
								frmdata:obj,
								ka:ka
							},
							success: function(result) { 
								$('#csp').val(result);
								return true;			
							}
							
						});
					}
					return false;
				}
				
				
               // return true;
            });
			
			$(document).on('click', ".way", function (){ 		
				var way = $("input[name='way']:checked").val();
				if(way=="2"){
					$('.returndateSelect').show('slow');
				}
				else
				{
					$('.returndateSelect').hide('slow');
				}
			});
			
			
			 
});

Book={
	
	FinishedClk:function()
	{
	},
	FormData:function(frmid)
	{
		var frmdata=$('form#'+frmid).serializeArray(); 
		obj = {};
		$(frmdata).each(function(i, field){
			obj[field.name] = field.value;
		});
		return obj;
	},
	StepsValidate:function(stepNumber)
	{
		var csp=$('#csp').val();
		var currentURL = window.location.href;
		var curl=currentURL.split('#step-');
		var currenturl=curl[0];
		
		if((csp=="")&&(curl[1]>1))
		{
			currenturl=currenturl+"#step-1";
			window.location.replace(currenturl);
		}
		
		
		
		
	},	
	NextProcess:function(e, anchorObject, stepNumber,stepDirection, stepPosition)
	{
		
		
		$(".btn-finish").hide();
	   if(stepPosition === 'first'){
		   $(".btn-finish").hide();
		   $('.sw-btn-next').show();
	   }else if(stepPosition === 'final'){
		   $('.sw-btn-next').hide();
		   $(".btn-finish").show();
	   }else{
			$(".btn-finish").hide();
			 $('.sw-btn-next').show();
	   }
	}
};
		
		
	