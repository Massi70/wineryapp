<script>
 $(document).ready(function(){
	$('#form1').submit(function(){
	var name = $('#name').val();
	var image = $('#image').val();
	var description = $('#description').val();
	var venue = $('#venue').val();
	var timedate = $('#timedate').val();
	var flavour = $('#flavour').val();
	var entryfee = $('#entryfee').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var latitude = $('#latitude').val();
	var longitude = $('#longitude').val();
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
		}
		if(email==''){
		$('.error').html('Please enter event Email');
		$('.error').show();
		return false;
		}
		if(phone==''){
		$('.error').html('Please enter event Phone');
		$('.error').show();
		return false;
		}
		if(latitude==''){
		$('.error').html('Please enter event latitude');
		$('.error').show();
		return false;
		}
		if(longitude==''){
		$('.error').html('Please enter event longitude');
		$('.error').show();
		return false;
		}
		
		
	});
});

 </script>
 
  <br clear="all" />
    <br clear="all" />

<br><br>

<?php //echo "<pre>";	print_r($winery);
//echo $winery[0]['winery_id'];  ?>

<div class="module" id="module" style="display:block;">
    <h2><span>Add New Event</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/events/addEvent/" enctype="multipart/form-data"  method="post" id="form1">
      
      <table>
      <tr>
          <td align="left" valign="top">  Event Name : </td>
          <td><input type="text" name="name" id="name"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Select Winery for Event : </td>
          <td><select name="winery" id="winery" onchange="document.getElementById('winery_id').value=this.value" ><?php foreach($winery as $name){  ?>
          <option value="<?php echo $name['winery_id'];?>" > &nbsp; <?php echo $name['wine_name'];?> &nbsp; </option>
		  <?php } ?>
          </select>
          </td>
      </tr>
          <input type="hidden" name="winery_id" id="winery_id" value="<?php echo $name['winery_id'];?>"  />

      
      <tr>
          <td align="left" valign="top">  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Description : </td>
          <td><input type="text" name="description" id="description"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Venue : </td>
          <td><input type="text" name="venue" id="venue"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Time : </td>
          <td><input type="text" name="timedate" id="timedate"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Flavour : </td>
          <td><input type="text" name="flavour" id="flavour"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Entry Fee : </td>
          <td><input type="text" name="entryfee" id="entryfee"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Contact Person : </td>
          <td><input type="text" name="contact" id="contact"  /></td>
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
          <td><input type="text" name="phone" id="phone"  /></td>
      </tr>

 	  <tr>
          <td align="left" valign="top">  Map Latitude : </td>
          <td><input type="text" name="latitude" id="latitude"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Map Longitude : </td>
          <td><input type="text" name="longitude" id="longitude"  /></td>
      </tr>
     
      <tr>
      <td></td>
      		<td><input type="submit" name="submit" value="submit"></td>
      </tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 

  
  
  <!-- End .module -->