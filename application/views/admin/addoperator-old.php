<script>
 $(document).ready(function(){
	$('#form1').submit(function(){
	var operatorname = $('#operatorname').val();
	var password = $('#password').val();
	var email = $('#email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var image = $('#file').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	$('.error').hide();
		//alert('hi');

		if(operatorname==''){
			$('.error').html('Please enter Operator Name ');
			$('.error').show();
			return false;
		}

		if(password==''){
			$('.error').html('Please enter Password ');
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
		}
		
		if(province==''){
			$('.error').html('Please enter province');
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
		}
	});
});

 </script>
 
  <br clear="all" />
    <br clear="all" />

<br><br>

<?php //echo "<pre>";	print_r($winery);  ?>

<div class="module" id="module" style="display:block;">
    <h2><span>Add New Tour Operator</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/touroperators/addOperator/" enctype="multipart/form-data"  method="post" id="form1">
      
      <table>
      <tr>
          <td align="left" valign="top">  Operator Name : </td>
          <td><input type="text" name="operatorname" id="operatorname"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Password : </td>
          <td><input type="password" name="password" id="password"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Email : </td>
          <td><input type="text" name="email" id="email"  /></td>
      </tr>

      <tr>
          <td align="left" valign="top">  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      </tr>

      <tr>
          <td align="left" valign="top">  Country : </td>
          <td><input type="text" name="country" id="country"  /></td>
      </tr>

      <tr>
          <td align="left" valign="top">  Province : </td>
          <td><input type="text" name="province" id="province"  /></td>
      </tr>
       
      <tr>
          <td align="left" valign="top">  Address : </td>
          <td><input type="text" name="address" id="address"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Contact : </td>
          <td><input type="text" name="contact" id="contact"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Web Link : </td>
          <td><input type="text" name="link" id="link"  /></td>
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