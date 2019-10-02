<script src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false" type="text/javascript"></script>
<style>
#mask {
 display: none;
 background: #000;
 position: fixed;
 left: 0;
 top: 0;
 z-index: 10;
 width: 100%;
 height: 100%;
 opacity: 0.8;
 z-index: 999;
}
#popup
{
 background-color:#CCC;
 position:absolute;
 left:28%;
 top:10%; 
 display:none; 
 z-index:9999;
}
.btn_close{
  position: absolute;
    right: 3px;
    top: 4px;
    z-index: 10000;
}

#loc_map {
	position:absolute;
	width:340px;
	height:380px;
	z-index:1;
	left: 599px;
	top: 320px;
}
</style>
<script>

 $(document).ready(function(){
	$('#form1').submit(function(){
	var name = $('#name').val();
	var regExpr = /^[a-zA-Z]+$/;	
	var image = $('#file').val();
	var description = $('#description').val();
	var venue = $('#venue').val();
	var timedate = $('#timedate').val();
	var flavour = $('#flavour').val();
	var entryfee = $('#entryfee').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;	
	var email = $('#email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var phone = $('#phone').val();
	var latitude = $('#latitude').val();
	var longitude = $('#longitude').val();
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;

	$('.error').hide();
		//alert('hi');

		if(name==''){
			$('.error').html('Please enter Event Name ');
			$('.error').show();
			return false;
		}

		if(image==''){
			$('.error').html('Please Upload an Image');
			$('.error').show();
			return false;
		}

		if(description==''){
			$('.error').html('Please enter event Description');
			$('.error').show();
			return false;
		}

		if(venue==''){
			$('.error').html('Please enter event Venue');
			$('.error').show();
			return false;
		}
		if(timedate==''){
			$('.error').html('Please enter event Time Date');
			$('.error').show();
			return false;
		}
		if(flavour==''){
			$('.error').html('Please enter event Flavour');
			$('.error').show();
			return false;
		}
		if(entryfee==''){
			$('.error').html('Please enter event entry fee');
			$('.error').show();
			return false;
		}
		if(contact==''){
			$('.error').html('Please enter event contact Person');
			$('.error').show();
			return false;
		}
		if(wlink==''){
			$('.error').html('Please enter event Web Link');
			$('.error').show();
			return false;
		}else if(!wlinkReg.test(wlink)){
			$('.error').html('Enter Proper Link');
			$('.error').show();
			return false;
		}
		if(email==''){
			$('.error').html('Please enter Email Address');
			$('.error').show();
			return false;
		}else if(!emailReg.test(email)){
			$('.error').html('Please enter valid Email Adress');
			$('.error').show();
			return false;
		}
		if(phone==''){
			$('.error').html('Please enter event Phone');
			$('.error').show();
			return false;
		}else if(!numericReg.test(phone)){
       		$('.error').html('Please enter Numbers only for phone');
			$('.error').show();
			return false;
    	}
		
	});
});

 </script>
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
		title: 'hellow worldsS',
		draggable:true,	
		position: latlng
	});
document.getElementById('txt_latlng').value=lat+", "+long;
	//var latLongVal = lat+","+long;
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
		document.getElementById('txt_latlng').value=point.lat()+", "+point.lng();
		
		
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
	
	
     
	google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(16);
    map.setCenter(marker.getPosition());
	
  });
 }
 
</script>
<body  onload="initialize(54.526176158712154, -124.92302684960941)">
<div id="loc_map"></div>
   <br clear="all" />
<div class="module" id="module" style="display:block;">
    <h2><span>Add New Event</span></h2>
    <?php //echo "<pre>";	print_r($winery);
//echo $winery[0]['winery_id'];  ?>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/events/addEvent/" enctype="multipart/form-data"  method="post" id="form1">
      
      <table>
      <tr>
          <td align="left" valign="top">  Event Name : </td>
          <td><input type="text" name="name" id="name" maxlength="30"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Select Winery for Event : </td>
          <td><select name="winery" id="winery" onChange="document.getElementById('user_id').value=this.value">
		  <?php foreach($winery as $name){  ?>
          <option value="<?php echo $name['id'];?>" selected="selected" > &nbsp; <?php echo $name['user_name'];?> &nbsp; </option>
		  <?php } ?>
          </select>
          </td>
      </tr>
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $name['id'];?>"  />

      
      <tr>
          <td align="left" valign="top">  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Description : </td>
          <td><textarea cols="20" rows="5" id="description" name="description" maxlength="120" > </textarea></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Venue : </td>
          <td><input type="text" name="venue" id="venue" maxlength="50" /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Time : </td>
          <td><input type="text" name="timedate" id="timedate" maxlength="20" placeholder="1930-01-01 11:59:50" /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Flavour : </td>
          <td><input type="text" name="flavour" id="flavour" maxlength="30" /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Entry Fee : </td>
          <td><input type="text" name="entryfee" id="entryfee" maxlength="10"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Contact Person : </td>
          <td><input type="text" name="contact" id="contact" maxlength="50" /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Web Link : </td>
          <td><input type="text" name="link" id="link"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Email : </td>
          <td><input type="text" name="email" id="email"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Phone Number : </td>
          <td><input type="text" name="phone" id="phone" maxlength="15" /></td>
      </tr>
		<input type="hidden" name="txt_latlng" id="txt_latlng" /></td>

      <tr>
      <td></td>
      		<td><input class="submit-green" type="submit" name="submit" value="Create"></td>
      </tr>
     </table>
<br /><br /><br /><br />

     <div>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
  <!-- End .module-table-body --><!-- End .module -->