<script>
function add_bonus()
{
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
}
$('a[id^="update_bet_bonus"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('update_bet_bonus',''));
top.location="<?php echo base_url();?>admin/wineries/?id="+id;
});
</script>
<script>
 $(document).ready(function(){
	$('#form1').submit(function(){
	var name = $('#name').val();
	var description = $('#description').val();
	var venue = $('#venue').val();
	var timedate = $('#timedate').val();
	var flavour = $('#flavour').val();
	var entryfee = $('#entryfee').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var email = $('#email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var phone = $('#phone').val();
	var latitude = $('#latitude').val();
	var longitude = $('#longitude').val();
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	$('.error').hide();
		//alert('hi');

		if(name==''){
			$('.error').html('Please enter Event Name ');
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
			$('.error').html('Please enter event Email');
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
       		$('.error').html('Only Numbers For Phone Number');
			$('.error').show();
			return false;
    	}
	});
});

 </script>

<?php //echo "<pre>";print_r($data); ?>
<div class="module" id="module" style="display:block;">
    <h2><span>Edit Event Details</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/events/update/" enctype="multipart/form-data"  method="post" id="form1">
      <input type="hidden" name="event_id" value="<?php echo $data[0]['event_id'];?>"  />
      <table>
      <tr>
          <td align="left" valign="top">  Event Name : </td>
          <td><input type="text" name="name" id="name" value="<?php echo $data[0]['event_name'];?>" /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Description : </td>
          <td><textarea cols="20" rows="5" id="description" name="description" maxlength="120" > <?php echo $data[0]['description'];?> </textarea></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Venue : </td>
          <td><input type="text" name="venue" id="venue" value="<?php echo $data[0]['venue'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Time : </td>
          <td><input type="text" name="timedate" id="timedate" value="<?php echo $data[0]['timedate'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Event Flavour : </td>
          <td><input type="text" name="flavour" id="flavour"  value="<?php echo $data[0]['flavour'];?>"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Entry Fee : </td>
          <td><input type="text" name="entryfee" id="entryfee" value="<?php echo $data[0]['entry_fee'];?>"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Contact Person : </td>
          <td><input type="text" name="contact" id="contact" value="<?php echo $data[0]['contact'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Web Link : </td>
          <td><input type="text" name="link" id="link" value="<?php echo $data[0]['link'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Email : </td>
          <td><input type="text" name="email" id="email" value="<?php echo $data[0]['email'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Phone Number : </td>
          <td><input type="text" name="phone" id="phone" value="<?php echo $data[0]['phone'];?>"  /></td>
      </tr>

	  <!--<tr>
          <td align="left" valign="top">  Map Latitude : </td>
          <td><input type="text" name="latitude" id="latitude" value="<?php //echo $data[0]['latitude'];?>"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Map Longitude : </td>
          <td><input type="text" name="longitude" id="longitude" value="<?php //echo $data[0]['longitude'];?>"   /></td>
      </tr>-->
      
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