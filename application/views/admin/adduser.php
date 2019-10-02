<script language="javascript">
 $(document).ready(function(){
	$('#button1').click(function(){
	var app_type = $('#app_type').val();
	var user_name = $('#user_name').val();
	var regExpr = /^[a-zA-Z]+$/;
	var letterReg = /^[a-zA-Z0-9 _]*[0-9]+[a-zA-Z0-9 _]*$/;
	var email = $('#user_email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	var password = $('#password').val();
	var cpassword = $('#confirmpassword').val();
	var file = $('#file').val();
	var contact = $('#contact').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var wlink = $('#link').val();
	//var description = $('#description').val();
	//var notes = $('#notes').val();
	var user_type = $('#user_type').val();

	$('.error').hide();
	
		if(app_type==''){
			$('.error').html('Please Select Any App Type ');
			$('.error').show();
			return false;
		}
		
		if(user_name==''){
			$('.error').html('Please enter User Name ');
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

		if(password==''){
			$('.error').html('Please enter password');
			$('.error').show();
			return false;
		}

		if(cpassword==''){
			$('.error').html('Please enter confirm password');
			$('.error').show();
			return false;
		}
		
		if(password != cpassword){
			$('.error').html('Password Does not Matches');
			$('.error').show();
			return false;
		}
		
		if(file==''){
			$('.error').html('Please Upload Image');
			$('.error').show();
			return false;
		}

		if(contact==''){
			$('.error').html('Please enter Contact');
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
			$('.error').html('Enter Only Alphabets for Province');
			$('.error').show();
			return false;
		}
		
		if(address==''){
			$('.error').html('Please enter address');
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
		
		/*if(description==''){
			$('.error').html('Please enter Description');
			$('.error').show();
			return false;
		}
		
		if(notes==''){
			$('.error').html('Please enter Notes');
			$('.error').show();
			return false;
		}*/
		
		if(user_type==''){
			$('.error').html('Please Select Any User Type ');
			$('.error').show();
			return false;
		}
		else{
			$.ajax({
			type:"post",
			url:'<?php echo base_url();?>admin/users/checkUsers/'+email,
			beforeSubmit:function(){
				},
			complete:function(){
				},
			success:function(data){
					if(data=='false')
					{
						document.form2.submit();
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

</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php //if(isset($msg)) echo $msg; ?>
  
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  	<span id="download_spinner" style="display:none;">Please Wait...</span>
  </div>
   <div class="module" id="module" >
    <h2><span>Add New User</span></h2>
 <div class="module-table-body">
 <center> 
	<span style="color:#F00" id="email_arleady_exist"></span>
 	<span class="error" style="color:#F00"> <?php //if(isset($msg)) echo $msg;?> </span>
 </center>
  	 	<form name="form2" id="form2" action="<?php echo base_url();?>index.php/admin/users/addUser/" method="POST" enctype="multipart/form-data" >
 <table width="100%" height="111" class="tablesorter" id="myTable">
  <tbody>
     <tr>
        <td>&nbsp;<b>Application Type : </b></td>
        <td><select id="app_type" name="app_type">
        <option value="" >Select Any Type </option>
        <option value="1" >British Columbia</option>
        <option value="2" >Ontario </option>
        </select></td>
     </tr>

     <tr>
         <td><b> &nbsp;User Name : </b></td>
         <td><input type="text" id="user_name" name="user_name" /></td>
     </tr>

    <tr>
        <td>&nbsp;<b>User Email : </b></td>
        <td><input type="text" name="user_email" id="user_email"  /></td>
     </tr>


    <tr>
        <td>&nbsp;<b>Password : </b></td>
        <td><input type="password" name="password" id="password"  /></td>
     </tr>


    <tr>
        <td>&nbsp;<b>Confirm Password : </b></td>
        <td><input type="password" name="confirmpassword" id="confirmpassword"  /></td>
     </tr>


	<tr>
 	    <td>&nbsp;<b>Upload Image : </b></td>
        <td><input type="file" name="file" id="file"  /></td>
     </tr>


  	<tr>
 	    <td>&nbsp;<b>Contact : </b></td>
        <td><input type="text" name="contact" id="contact"  /></td>
     </tr>


	<tr>
 	    <td>&nbsp;<b>Country : </b></td>
        <td><input type="text" name="country" id="country"  /></td>
     </tr>


	<tr>
 	    <td>&nbsp;<b>Province : </b></td>
        <td><input type="text" name="province" id="province"  /></td>
     </tr>


	<tr>
 	    <td>&nbsp;<b>Address : </b></td>
        <td><textarea cols="20" rows="5" id="address" name="address" maxlength="120" ></textarea></td>
     </tr>


  	 <tr>
        <td>&nbsp;<b>Web Link : </b></td>
        <td><input type="text" name="link" id="link"  /></td>
     </tr>


  	 <tr>
        <td valign="middle">&nbsp;<b>Description : </b></td>
        <td><textarea cols="20" rows="5" id="description" name="description"> </textarea></td>
     </tr>

  
   <tr>
        <td valign="top">&nbsp;<b>Notes : </b></td>
         <td><textarea cols="20" rows="5" id="notes" name="notes"> </textarea></td>
     </tr>
   
  	<tr>
        <td>&nbsp;<b>User Type : </b></td>
        <td><select id="user_type" name="user_type">
        <option value="" >Select User </option>
        <option value="2" >Winery Operator</option>
        <option value="3" >Tour Operator </option>
        </select></td>
     </tr>

   
     <tr>
         <td>&nbsp;</td>
         <td>&nbsp;<input class="submit-green" type="button" id="button1" value="Register" name="button1" /></td>
     </tr>
   </tbody>
 </table>
      </form>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>
