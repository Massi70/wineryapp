<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Winery App</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style_web.css">
<link href='//fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
<!-- include jQuery library -->
<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
<script src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo base_url();?>css/validationEngine.jquery.css" type="text/css"/>
<script src="<?php echo base_url();?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url();?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>

<!-- include Cycle plugin -->
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.cycle.all.latest.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/orbit.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/jstyle.css" type="text/css" media="screen" />
<style type="text/css">
#featured {
	width: 457px !important;
	height: 250px !important;
	background: #F5D192 url('orbit/loading.gif') no-repeat center center;
	overflow: hidden;
	border: 2px solid #C79232;
	border-radius: 13px 13px 13px 13px;
	-moz-border-radius: 13px 13px 13px 13px;
	-ms-border-radius: 13px 13px 13px 13px;
	-o-border-radius: 13px 13px 13px 13px;
	-webkit-border-radius: 13px 13px 13px 13px;
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.orbit.min.js"></script>

<script type="text/javascript">
			$(window).load(function() {
				$('#featured').orbit({
					btnNext: ".next",
        			btnPrev: ".prev",
        			visible: 5,
					'animation' : 'horizontal-slide'
				});
			});
		</script>-->
        
        <!-- Run the plugin -->
<script type="text/javascript">
$(document).ready(function() {
	
	
 		//created by reha pop up
		
		$('a.popupslider').click(function() {
			 
			// Getting the variable's value from a link 
			var popBox = $(this).attr('href');
	
			//Fade in the Popup and add close button
			$(popBox).fadeIn(300);
			
			//Set the center alignment padding + border
			var popMargTop = ($(popBox).height() + 24) / 2; 
			var popMargLeft = ($(popBox).width() + 24) / 2; 
			
			$(popBox).css({ 
				'margin-top' : -popMargTop,
				'margin-left' : -popMargLeft
			});
			
			// Add the mask to body
			$('body').append('<div id="mask"></div>');
			$('#mask').fadeIn(300);
			
			return false;
		});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close').click(function() { 
	  $('#mask , .popup ').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
	
	
	$('.login_restaurant_owner').live('click',function() { 
	   
	   	$('.add_login_restaurant_owner').removeClass('login_restaurant_owner');
		
		  //if invalid do nothing
         if(!$("#formID").validationEngine('validate')){
			
			$('.add_login_restaurant_owner').addClass('login_restaurant_owner');
        	 return false;
          }
		  
		  var dataString = 'user_name=' + $('#formID input[name=user_name]').val() + '&password=' + $('#formID input[name=password]').val();
		  
		  $.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/index/signin",
			data: dataString,
			dataType:"json",
			success: function (data) {
				
				if(data.status=='FAILURE')
				{
					 
					$('.error_div').text(data.message);
					$('.error_div').fadeIn(200);
					
				}
				else
				{
					//if(data.user_data.)
					window.location ="<?php echo base_url();?>index/home/";
				}
				
				$('input[name=user_name]').val('');
				$('input[name=password]').val('');
				$('.add_login_restaurant_owner').addClass('login_restaurant_owner');
			  
			}
		  });
		  
		  return false;
	
	});
	
	$('.forgot_password').live('click',function() { 
	   
	   	$(this).removeClass('forgot_password');
		
		  //if invalid do nothing
         if(!$("#forgotPaasowrdForm").validationEngine('validate')){
			
			$('#forgotPaasowrdForm a').addClass('forgot_password');
        	 return false;
          }
		  
		  var dataString = 'user_name=' + $('#forgotPaasowrdForm input[name=user_name]').val() ;
		  $.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/index/ForgotPassword",
			data: dataString,
			dataType:"json",
			success: function (userData) {
				
				  
				$('.error_div_forgot_password').text(userData.message);
				$('.error_div_forgot_password').fadeIn(1000);
				 
				$('#forgotPaasowrdForm input[name=user_name]').val('');
				$('#forgotPaasowrdForm a').addClass('forgot_password');
			  
			}
		  });
		  
		  return false;
	
	});
	/* Save Restaurant Start*/
	
	$('#form_save_restaurant').live('submit',function() { 
	   $('.error_div_registration').html('<img src="<?php echo base_url();?>images/loader.gif" >') 
		  //if invalid do nothing
         if(!$("#form_save_restaurant").validationEngine('validate')){
		 	$('.save_btn').addClass('save_restaurant_owner');
			 $('.error_div_registration').fadeOut();
        	 return false;
          }
		  var formData = new FormData($(this)[0]);
 
		 // var dataString = $('#form_save_restaurant').serialize();
		  $.ajax({
			type: "POST",
			url: "<?php echo base_url();?>/index/signup",
			data: formData,
			dataType:"json",
			async: false,
			success: function (userData) {
				
				if(userData.status=='FAILURE')
				{
					 
					$('.error_div_registration').text(userData.message);
					$('.error_div_registration').fadeIn(200);
					
				}
				else
				{
					$('#form_save_restaurant').each (function(){  
						this.reset();
					 }); 
					$('.error_div_registration').text(userData.message);
					$('.error_div_registration').fadeIn(200);
					
					setTimeout(function(){ window.location ="<?php echo base_url();?>index/registration";},2000)
 
				}
 
				$('.save_btn').addClass('save_restaurant_owner');
			  
			},
			cache: false,
			contentType: false,
			processData: false
		  });
		  
		  return false;
	
	});
	/* Save Restaurant End*/
	
	
});
function popUpForgotPasswid()
{
	 
	$('a.close').trigger('click' )
	 setTimeout(
	 	function(){
				// Getting the variable's value from a link 
				var popBox = '#forgotPassword';
			
				//Fade in the Popup and add close button
				$(popBox).fadeIn(300);
				
				//Set the center alignment padding + border
				var popMargTop = ($(popBox).height() + 24) / 2; 
				var popMargLeft = ($(popBox).width() + 24) / 2; 
				
				$(popBox).css({ 
					'margin-top' : -popMargTop,
					'margin-left' : -popMargLeft
				});
				
				// Add the mask to body
				$('body').append('<div id="mask"></div>');
				$('#mask').fadeIn(300);
						
				return false;
	  
	  },1000)
}
</script>

<!--<link rel="stylesheet" href="<?php echo base_url(); ?>js/themes/default/css/uniform.default.css" media="screen" />
<script src="<?php echo base_url(); ?>js/jquery.uniform.js"></script>
<script type="text/javascript">
 
$(function () {
	$("select").uniform();
});

</script>-->
</head>
<body onload="">

<div class="wrapper">
<div class="header">
    <div class="logo"><img src="<?php echo base_url(); ?>images/logo.png" /></div>
    <div id="social_icon" style="margin-top:80px; text-align:right;">
          
            
            <?php
			if($this->session->userdata("user_login"))
			{
			?> 
            <a href="<?php echo base_url(); ?>index/logOut" class=" faq ">
                Logout
            </a>
            <?php
			}
			else
			{?>
            <a href="<?php echo base_url(); ?>index/registration" class=" faq ">
                Register
            </a>
            <a href="#LoginPopUpRestaurantOwner" class="popupslider faq">
                Log in
            </a>
           	<?php
			}?>
            
             
        </div>
</div>


<div class="nav">
<?php
			if($this->session->userdata("user_login"))
			{
			?> 
             <ul>
                <li <?php if($pageName=='Profile'){ echo 'class="active"';} ?> >
                    <a href="<?php echo base_url();?>/index/home/" >
                        Profile
                    </a>
                </li>
              <?php
			    if($val['user_type_id']==2)
				{
				?>
                <li <?php if($pageName=='events'){ echo 'class="active"';} ?>>
                     <a href="<?php echo base_url();?>/index/events/" >
                        Events
                    </a>
                </li>
               <?php
				}
			  ?>
            </ul> 
            <?php
			}
			 ?>
    
</div>




<!--<div id="header_area">
    <div id="header">
        <div id="logo">
            <a href="#">
                <img src="<?php echo base_url(); ?>images/logo.png" />
            </a>
        </div>
        <div id="social_icon" style="margin-top:80px; text-align:right;">
          
            
            <?php
			if($this->session->userdata("user_login"))
			{
			?> 
            <a href="<?php echo base_url(); ?>index/logOut" class=" faq ">
                Logout
            </a>
            <?php
			}
			else
			{?>
            <a href="#register" class="popupslider faq ">
                Register
            </a>
            <a href="#LoginPopUpRestaurantOwner" class="popupslider faq">
                Log in
            </a>
           	<?php
			}?>
            
             
        </div>
    </div>
</div>
<div class="wrapper">
<div id="main">
<div id="menu">
     
</div>
-->