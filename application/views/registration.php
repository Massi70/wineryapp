<script language="javascript">
function initialize(lat , long) 
 {
	//alert('initliz');
	// Make an instance of Geocoder
	geocoder = new google.maps.Geocoder();
	// Set static latitude, longitude value
	var latlng = new google.maps.LatLng(lat,long);
	// Set map options
	var myOptions = {
		zoom: 12,
		center: latlng,
		panControl: true,
		zoomControl: true,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	// Create map object with options
	map = new google.maps.Map(document.getElementById("loc_map"), myOptions);
	// Create and set the marker
	marker = new google.maps.Marker({
		map: map,
		title: 'Place Marker on your Location',
		draggable:true,	
		position: latlng
	});
	document.getElementById('txt_latlng').value=lat+","+long;
	var latLongVal = lat+","+long;
	//getAddressFromlatLong(latLongVal);
	// Register Custom "dragend" Event
	google.maps.event.addListener(marker, 'dragend', function() {
		
		// Get the Current position, where the pointer was dropped
		var point = marker.getPosition();
		// Center the map at given point
		map.panTo(point);
		// Update the textbox
		var latLongValue = point.lat()+","+point.lng();
		//getAddressFromlatLong(latLongValue);
		//document.getElementById('txt_latlng').value=point.lat()+", "+point.lng();
		
		
	});
	
	google.maps.event.addListener(marker, 'dragend', function() {
		
		// Get the Current position, where the pointer was dropped
		var point = marker.getPosition();
		// Center the map at given point
		map.panTo(point);
		// Update the textbox
		
		document.getElementById('txt_latlng').value=point.lat()+", "+point.lng();
		var latLongValue = point.lat()+","+point.lng();
		//getAddressFromlatLong(latLongValue);
	});
	
	var iw1 = new google.maps.InfoWindow({
       content: "<strong style='font-size:30px'>Home For Sale</strong>"
     });
     
	google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(16);
    map.setCenter(marker.getPosition());
	iw1.open(map, this);
  });
 }
 
 function getAddressFromlatLong(latLong, event_flag)
{
	$.ajax({
	
			type: "POST",
	
			url:base_url+"ajax/getAddressFromLatLong",
			data: {'latLong':latLong },
			dataType:'JSON',
			success: function(response){
			if(response.data !='error' ||response.data != 'no_response' )
			{	
				if(event_flag)
				{
					$("#event_location").val(response.address);
					$("#event_city").val(response.city);
					$("#event_location").attr("readonly", true)
					//console.log(response.results.formatted_address);
					$("select#event_country option").each(function() { this.selected = (this.text == response.country); });
				}
				else
				{
					$("#location").val(response.address);
					$("#city").val(response.city);
					$("#location").attr("readonly", true)
					$("select#country_id option").each(function() { this.selected = (this.text == response.country); });
				}
				
				
				//console.log(response.results.formatted_address);
				
			}
		}
	
		});
}


//initialize(24.045435,60.3434);
 $(document).ready(function(){
	 
	initialize(<?php echo $lat?>, <?php echo $long?>)
	
	 
	$('#user_type').on('click', function() {
	   if(this.value ==2)
	  {
		 $('#add_fields').html(' <input type="text" placeholder="Notes" id="notes" name="notes" class="validate[required] lrg_field rgt_mrg"><textarea class="validate[required] textarea" name="detail" id="detail" placeholder="Description" ></textarea>')
	  }
	  else
	  { 	
	  	$('#add_fields').html('')
	  }
	    
	});
	 
	/*$('#form').submit(function(){
	var user_name = $('#user_name').val();
	var email = $('#user_email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	var user_type = $('#user_type').val();
	$('.error').hide();

		if(user_name==''){
			$('.error').html('Please enter User Name ');
			$('.error').show();
			return false;
		}if(email==''){
			$('.error').html('Please enter Email ');
			$('.error').show();
			return false;
		}else if(!emailReg.test(email)){
			$('.error').html('Please enter valid Email Adress');
			$('.error').show();
			return false;
		}if(password==''){
			$('.error').html('Please enter Password');
			$('.error').show();
			return false;
		}if(cpassword==''){
			$('.error').html('Please enter Confirm Password');
			$('.error').show();
			return false;
		}else if((password) != (cpassword)){
			//alert('User Match');
			$('.error').html('Password Donot Match');
			$('.error').show();
			return false;
		}if(user_type ==''){
			$('.error').html('Please Select any one');
			$('.error').show();
			return false;
		}
	});*/
});

</script>
 

<div class="content">
    <div class="title_area">
        <h1>Reistration</h1>
        
    </div>
    <div class="deals_popup pop_mrg_lft">
            <form enctype="multipart/form-data" action="<?php echo base_url();?>/index/signup" method="post" id="form_save_restaurant" name="register">
            <div class="add_section">
               
                
 				<input type="text" placeholder="User Name" id="user_name" name="user_name" class="validate[required] small_field rgt_mrg">
                <input type="text" placeholder="email" id="user_email" name="user_email" class="validate[required,custom[email]] small_field rgt_mrg">
                <input type="password" id="rpassword" name="rpassword" placeholder="password" class="validate[required,minSize[6]] small_field rgt_mrg">
                <input type="password" id="conform_rpassword" name="conform_rpassword" placeholder="conform password" class="validate[required,equals[rpassword]] small_field">
                <input type="text" placeholder="Contact No" id="Contact" name="Contact" class="validate[required] small_field rgt_mrg">
                <input type="text" placeholder="Web Link " id="web_link" name="web_link" class="validate[required] small_field rgt_mrg"> 
                <div class="styleThese bdr_radius_five">
               <input type="radio" id="app_type" name="app_type" class="validate[required]" value="1">british columbia
               <input type="radio"   id="app_type1" name="app_type" class="validate[required]" value="2">ontario
                </div>
                <div class="styleThese bdr_radius_five">
                    <select class="validate[required]" name="user_type" id="user_type">
                        <option value="" selected="selected">Select Type</option>
                        <option value="2">Winery</option>
                        <option value="3">Commercial Tour Operator</option>
                    </select>
                </div>
                <input type="file" class="small_field validate[required] " placeholder="Upload Image" name="file" id="file">
               <div id="add_fields">
                          	
               </div>
                  <input type="hidden"  type="text" name="txt_latlng" id="txt_latlng" />
				<div id="loc_map" style="width:500px; height:500px"></div>
               <input type="submit" value="Save" class="save_btn">
                
                <div style="color:red; display:none; float:right; margin:4px 20px 0 0;" class="error_div_registration"></div>
           <br clear="all" />
            </div>
           
            </form>
        </div>
</div>

  <!-- End .module -->
  
  
  <!-- Registraiotn Pop up End -->

<div id="map_popup" class="popup">
    <a href="#" class="close">
        <img src="<?php echo base_url(); ?>images/popup-close-btn.png" class="btn_close_rdPop" title="Close Window" alt="Close" />
    </a>
    <div class="popup_area">
        <div class="restaurant_popup">
            <div class="deals_content" style="width:100%"></div></div>
        </div>
    </div>
</div>