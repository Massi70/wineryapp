 <script>
 $(document).ready(function(){
	$('#form2').submit(function(){
	var user_name = $('#user_name').val();
	var email = $('#user_email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var contact = $('#contact').val();
	var password = $('#password').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var wlink = $('#link').val();
	
	$('.error').hide();
	
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
			$('.error').html('Please enter Password');
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

		if(wlink==''){
			$('.error').html('Please enter Web Link');
			$('.error').show();
			return false;
		}
		
	});
});

</script>
   <div class="module" >

    <h2><span>Update User</span></h2>
   <span class="error" style="color:#F00"> </span>
  	 	<form name="form2" id="form2" action="<?php echo base_url();?>index.php/admin/users/update/" method="POST" >
<br />
   <table width="0%" height="111" class="tablesorter" id="myTable" >
     <tbody>
     <?php //echo '<pre>';print_r($data);exit;
	 foreach($data as $val){ ?>
     
     <tr>
         <td><b> &nbsp;User Name : </b></td>
         <td><input type="text" id="user_name" name="user_name" value="<?php echo $val['user_name']; ?>" /></td>
          <input type="hidden" name="id" id="id" value="<?php echo $val['id'];?>"  />
     </tr>
    <tr>
        <td>&nbsp;<b>User Email : </b></td>
        <td><input type="text" name="user_email" id="user_email" value="<?php echo $val['user_email']; ?>"  /></td>
     </tr>

    <tr>
        <td>&nbsp;<b>User Password : </b></td>
        <td><input type="password" name="password" id="password" value="
		<?php echo $val['password'];?>"  />
        </td>
     </tr>

  	<tr>
 	    <td>&nbsp;<b>Contact : </b></td>
        <td><input type="text" name="contact" id="contact" value="<?php echo $val['contact']; ?>"  /></td>
     </tr>

	<tr>
 	    <td>&nbsp;<b>Country : </b></td>
        <td><input type="text" name="country" id="country" value="<?php echo $val['country']; ?>"  /></td>
     </tr>

	<tr>
 	    <td>&nbsp;<b>Province : </b></td>
        <td><input type="text" name="province" id="province" value="<?php echo $val['province']; ?>"  /></td>
     </tr>

	<tr>
 	    <td>&nbsp;<b>Address : </b></td>
        <td><textarea cols="20" rows="5" id="address" name="address" maxlength="120" ><?php echo $val['address']; ?></textarea>
       </td>
    </tr>
    
    <tr>
 	    <td>&nbsp;<b>Description : </b></td>
        <td><textarea cols="20" rows="5" id="description" name="description" maxlength="120" ><?php echo $val['description']; ?></textarea>
        </td>
   </tr>

  	<tr>
        <td>&nbsp;<b>Web Link : </b></td>
        <td><input type="link" name="link" id="link" value="<?php echo $val['link']; ?>"  /></td>
     </tr>
     <?php }?>
     <tr>
         <td>&nbsp;</td>
         <td>&nbsp;<input class="submit-green" type="submit" value="Register" name="submit" /></td>
     </tr>
     </tbody></table>

   </form>
   </div>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  <!-- End .module -->