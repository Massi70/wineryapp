<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	var operatorname = $('#operatorname').val();
	var email = $('#email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var regExpr = /^[a-zA-Z]+$/;
	var image = $('#file').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	$('.error').hide();

		if(operatorname==''){
			$('.error').html('Please enter Operator Name ');
			$('.error').show();
			return false;
		}

		if(email==''){
			$('.error').html('Please enter Email Adress');
			$('.error').show();
			return false;
		}else if(!emailReg.test(email)){
			$('.error').html('Please enter valid Email Adress');
			$('.error').show();
			return false;
		}
		
		if(image==''){
			$('.error').html('Please Upload an Image');
			$('.error').show();
			return false;
		}

		
		if(country==''){
			$('.error').html('Please enter country');
			$('.error').show();
			return false;
		}else if(!regExpr.test(country)){
			$('.error').html('Enter Only Alphabets for Province');
			$('.error').show();
			return false;
		}
		
		if(province==''){
			$('.error').html('Please enter province');
			$('.error').show();
			return false;
		}else if(!regExpr.test(province)){
			$('.error').html('Enter Only Alphabets for Province');
			$('.error').show();
			return false;
		}
		
		if(address==''){
			$('.error').html('Please enter address');
			$('.error').show();
			return false;
		}
		
		if(contact==''){
			$('.error').html('Please enter Contact');
			$('.error').show();
			return false;
		}

		if(wlink==''){
			$('.error').html('Please enter Web Link');
			$('.error').show();
			return false;
		}else if(!wlinkReg.test(wlink)){
			$('.error').html('Enter Proper Link');
			$('.error').show();
			return false;
		}
	});
});

 </script> 

<div class="module" id="module" style="display:block;">
    <h2><span>Edit Tour Operator Details</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/touroperators/update/" enctype="multipart/form-data"  method="post" id="form1">
      <input type="hidden" name="id" value="<?php echo $data[0]['id'];?>"  />
      <table>
      <tr>
          <td align="left" >   Operator Name : </td>
          <td><input type="text" name="operatorname" id="operatorname" value="<?php echo $data[0]['user_name']; ?>"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Email : </td>
          <td><input type="text" name="email" id="email" value="<?php echo $data[0]['user_email'];?>"   /></td>
      </tr>
      
      <tr>
          <td align="left" >  Country : </td>
          <td><input type="text" name="country" id="country" value="<?php echo $data[0]['country'];?>"   /></td>
      </tr>
      
      <tr>
          <td align="left" >  Province : </td>
          <td><input type="text" name="province" id="province" value="<?php echo $data[0]['province'];?>" /></td>
      </tr>
      
      <tr>
          <td valign="top" >  Address : </td>
          <td><textarea cols="20" rows="5" id="address" name="address" maxlength="120" ><?php echo $data[0]['address'];?></textarea>
          </td>
      </tr>
      
      <tr>
          <td align="left" >  Contact : </td>
          <td><input type="text" name="contact" id="contact" value="<?php echo $data[0]['contact'];?>"   /></td>
      </tr>
      
      <tr>
          <td align="left" >  Web Link : </td>
          <td><input type="text" name="link" id="link" value="<?php echo $data[0]['link'];?>"  /></td>
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