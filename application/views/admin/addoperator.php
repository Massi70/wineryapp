<script>
$(document).ready(function(){
	$('#button1').click(function(){
	var estate = $('#estate').val();
	var operatorname = $('#operatorname').val();
	var letterReg = /^[a-zA-Z0-9 _]*[0-9]+[a-zA-Z0-9 _]*$/;
	var regExpr = /^[a-zA-Z]+$/;		
	var password = $('#password').val();
	var email = $('#email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var image = $('#file').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;	
	$('.error').hide();
		//alert('hi');

		if(estate==''){
			$('.error').html('Please Select Any One Estate ');
			$('.error').show();
			return false;
		}
		
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
		}else if(!regExpr.test(country)){
			$('.error').html('Enter Only Alphabets for Country');
			$('.error').show();
			return false;
		}
		
		if(province==''){
			$('.error').html('Please enter province');
			$('.error').show();
			return false;
		}else if(!regExpr.test(province)){
			$('.error').html('Enter Only Alphabets for province');
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
		}else{
			$.ajax({
			type:"post",
			url:'<?php echo base_url();?>admin/touroperators/checkUsers/'+email,
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
		}
	
	});
});

 </script> 
  <br clear="all" />
<?php //echo "<pre>";	print_r($association);  ?>


<div class="module" id="module" style="display:block;">
    <h2><span>Add New Tour Operator</span></h2>
    <div class="module-table-body">
     <?php if(isset($msg)) echo $msg; ?>
 <center>
 	<span style="color:#F00" id="email_arleady_exist"></span>
    <span class="error" style="color:#F00"> </span>
 </center>
      <form action="<?php echo base_url()?>admin/touroperators/addOperator/" enctype="multipart/form-data"  method="post" id="form1">
      <table>
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
          <td align="left" valign="top">  Operator Name : </td>
          <td><input type="text" name="operatorname" id="operatorname" value="" maxlength="30"  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Password : </td>
          <td><input type="password" name="password" id="password" value=""  /></td>
      </tr>
      
      <tr>
          <td align="left" valign="top">  Email : </td>
          <td><input type="text" name="email" id="email"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Country : </td>
          <td><input type="text" name="country" id="country" maxlength="30"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Province : </td>
          <td><input type="text" name="province" id="province" maxlength="30"  /></td>
      </tr>
      <tr>
          <td align="left" >  Address : </td>
          <td><textarea cols="20" rows="5" id="address" name="address" maxlength="90" > </textarea></td>
      </tr>
      <tr>
          <td align="left" >  Contact : </td>
          <td><input type="text" name="contact" id="contact" maxlength="30"  /></td>
      </tr>
      <tr>
          <td align="left" >  Web Link : </td>
          <td><input type="text" name="link" id="link" maxlength="50" /></td>
      </tr>

      <tr>
      <td></td>
      		<td><input class="submit-green" type="submit" name="button1" id="button1" value="submit"></td>
      </tr>
     </table>
      </form>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  <!-- End .module -->