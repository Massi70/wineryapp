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
 left:25%;
 top:11%; 
 display:none; 
 z-index:9999;
 padding:16px;
 
}
.btn_close{
  position: absolute;
    right: 3px;
    top: 4px;
    z-index: 10000;
}
</style>

<script>
 $(document).ready(function(){
	$('#button1').click(function(){
	var estate = $('#estate').val();
	var name = $('#name').val();
	var letterReg = /^[a-zA-Z0-9 _]*[0-9]+[a-zA-Z0-9 _]*$/;
	var regExpr = /^[a-zA-Z]+$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	var email = $('#user_email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var password = $('#password').val();
	var image = $('#file').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var description = $('#description').val();
	var notes = $('#notes').val();
	//var item_file = document.getElementById('#item_file');
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
	$('.error').hide();

		if(estate==''){
			$('.error').html('Please Select Any One Estate ');
			$('.error').show();
			return false;
		}
		
		else if(name==''){
			$('.error').html('Please enter Winery Name ');
			$('.error').show();
			return false;
		}
		
		else if(email==''){
			$('.error').html('Please enter Email Address ');
			$('.error').show();
			return false;
		}else if(!emailReg.test(email)){
			$('.error').html('Please enter valid Email Adress');
			$('.error').show();
			return false;
		}
		
		else if(password==''){
			$('.error').html('Please enter Password ');
			$('.error').show();
			return false;
		}
		
		else if(image==''){
			alert('image link');
			$('.error').html('Please Upload an Image');
			$('.error').show();
			return false;
		}
		
		else if(country==''){
			$('.error').html('Please enter Wine Country');
			$('.error').show();
			return false;
		}else if(!regExpr.test(country)){
			$('.error').html('Enter Only Alphabets for Country');
			$('.error').show();
			return false;
		}

		else if(province==''){
			$('.error').html('Please enter Province');
			$('.error').show();
			return false;
		}else if(!regExpr.test(province)){
			$('.error').html('Enter Only Alphabets for Province');
			$('.error').show();
			return false;
		}

		else if(address==''){
			$('.error').html('Please enter address');
			$('.error').show();
			return false;
		}

		else if(contact==''){
			$('.error').html('Please enter contact Person');
			$('.error').show();
			return false;
		}

		else if(wlink==''){
			$('.error').html('Please enter Web Link');
			$('.error').show();
			return false;
		}else if(!wlinkReg.test(wlink)){
			$('.error').html('Enter Proper Link');
			$('.error').show();
			return false;
		}else{
			$.ajax({
			type:"post",
			url:'<?php echo base_url();?>admin/wineries/checkUsers/'+email,
			beforeSubmit:function(){
				},
			complete:function(){
				},
			success:function(data){
				//alert(data);
					if(data=='false')
					{
						//window.location('<?php //echo base_url();?>admin/wineries');
						//alert('submit form');
						document.form1.submit();
						//return true;
					}
					else
					{
						$('#email_arleady_exist').html('Email already exists');
						
					}
				}
			});	
			return false;
		}
	});
});

function AddressFromMap()
{
	//alert('aa');
	popup('popBoxMap');
	initialize(54.526176158712154, -124.92302684960941);
	$('body').append('<div id="mask"></div>');
	$('#mask').fadeIn(300);
		
}
function popup(id)
{
	$('#popup').fadeIn(300 , function() {
});
}
function closePopup(id)
{
	$('#popup').fadeOut(300 , function() {
	$('#mask').remove();
});
}

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
		title: 'Select Location',
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
 
 function saveAddress(){
	closePopup();
	return false;
	 
}
 
</script>
 <script language="javascript">
<!--
	function _add_more(){
		var txt = "<br><input type=\"file\" name=\"item_file[]\">";
		//document.getElementById("dvFile").innerHTML += txt;
		$('#dvFile').append('<br><input type=file name=item_file[] />');
	}
</script>

 <div style="float:left"> <a href="<?php echo base_url();?>admin/wineries/?type_id=all">Back To Wineries</a></div> 
<div class="module" id="module" style="display:block;">
    <h2><span>Add New Winery</span></h2>
    <div class="module-table-body">
    <?php //echo '<pre>';print_r($association);?>
 <center><span style="color:#F00" id="email_arleady_exist"></span>
  <span class="error" style="color:#F00">

  <?php if(isset($msg)) echo $msg;?> </span></center>
      <form action="<?php echo base_url()?>admin/wineries/addWine/" enctype="multipart/form-data"  method="post" id="form1" name="form1">
      <table>
      <tbody>
      <tr>
      	<td>Select One Estate:</td>
        <td><select name="estate" id="estate" >
        <option value="">Select Estate</option>
        <option value="1">British Columbia</option>
        <option value="2">Ontario</option>
        </select>
        </td>
      </tr>
      
      <tr>
          <td align="left" >  Winery Name : </td>
          <td><input type="text" name="name" id="name" maxlength="30"  /></td>
          
          <td align="left" >  Select Association : </td> 
          <td><select name="associations" id="associations" onchange="document.getElementById('association_id').value=this.value" ><?php foreach($association as $name){  ?>
          <option value="<?php echo $name['association_id'];?>" selected="selected" > &nbsp; <?php echo $name['association_name'];?> &nbsp; </option>
		  <?php } ?>
          </select>
          </td>
      </tr>
          <input type="hidden" name="association_id" id="association_id" value="<?php echo $name['association_id'];?>"  />

      <tr>
          <td align="left" >  User Email : </td>
          <td><input type="text" name="user_email" id="user_email"  /></td>
    
          <td align="left" >  Password : </td>
          <td><input type="password" name="password" id="password" maxlength="15" /></td>
      </tr>

      <tr>
          <td align="left" >  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      
          <td align="left" >  Country : </td>
          <td><input type="text" name="country" id="country" maxlength="20"  /></td>
      </tr>
      <tr>
          <td align="left" >  Province : </td>
          <td><input type="text" name="province" id="province" maxlength="20"  /></td>
    
          <td align="left" >  Address : </td>
          <td><textarea cols="20" rows="5" id="address" name="address" maxlength="100"> </textarea></td>
      </tr>
      <tr>
          <td align="left" >  Person Contact : </td>
          <td><input type="text" name="contact" id="contact" maxlength="30"  /></td>
     
          <td align="left" >  Web Link : </td>
          <td><input type="text" name="link" id="link" maxlength="30"  /></td>
      </tr>
      <tr>
          <td align="left" valign="baseline">  Description : </td>
          <td><textarea cols="20" rows="5" id="description" name="description" maxlength="120" > </textarea></td>
      
          <td align="left" valign="baseline">  Notes : </td>
          <td><textarea cols="20" rows="5" id="notes" name="notes" maxlength="120"> </textarea></td>
      </tr>

	<tr>
        <td>Upload number of Images : </td>
		<td><div id="dvFile"><input type="file" name="item_file[]" id="item_file[]"></div>
		<a href="javascript:_add_more();" title="Add more">
        <img src="<?php echo base_url(); ?>images/plus_icon.gif" border="0"></a></td>
     </tr>
      
      <tr>
      	<td></td>
          <div style="left:800px;top:630px; position:absolute;"><span><a href="javascript:;" onclick="AddressFromMap();" class="button"><span>Add Location</span> </a></div>
              <input type="hidden" name="txt_latlng" size="50" id="txt_latlng" /> 

      	<td><input class="submit-green" type="button" name="button1" id="button1" value="Create"></td>
      </tr>
     </table>
      </form>
      <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
      
<div id="popup">
<a href="#" class="close"><img src="<?php echo base_url()?>images/admin/close.png" onclick="closePopup();" class="btn_close" title="Close Window" alt="Close" /></a>

<div id="map_div">
<div id="loc_map" style="width:450px; height:450px" align="right"> </div>
      <span style="padding-left:405px;"><button name="button" onClick="saveAddress();">Done</button></span>
  
</div>
</div>    
    <!-- End .module-table-body --> 
  <!-- End .module -->
