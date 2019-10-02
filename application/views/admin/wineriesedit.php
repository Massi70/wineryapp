<script>
 $(document).ready(function(){
	$('#form1').submit(function(){
	var name = $('#name').val();
	var password = $('#password').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var contact = $('#contact').val();
	var wlink = $('#link').val();
	var description = $('#description').val();
	var notes = $('#notes').val();
	//var latitude = $('#latitude').val();
	//var longitude = $('#longitude').val();
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
	var regExpr = /^[a-zA-Z]+$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	$('.error').hide();
		//alert('hi');

		if(name==''){
			$('.error').html('Please enter Winery Name ');
			$('.error').show();
			return false;
		}
		
		if(password==''){
			$('.error').html('Please enter Password ');
			$('.error').show();
			return false;
		}

		if(country==''){
			$('.error').html('Please enter Winery Country');
			$('.error').show();
			return false;
		}else if(!regExpr.test(country)){
			$('.error').html('Enter Only Alphabets for Country');
			$('.error').show();
			return false;
		}

		if(province==''){
			$('.error').html('Please enter Province');
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
			$('.error').html('Please enter contact Person');
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
		
		if(description==''){
			$('.error').html('Please enter Description');
			$('.error').show();
			return false;
		}
		
		if(notes==''){
			$('.error').html('Please enter Notes');
			$('.error').show();
			return false;
		}
		/*if(latitude==''){
			$('.error').html('Please enter latitude');
			$('.error').show();
			return false;
		}else if(!numericReg.test(latitude)){
       		$('.error').html('Please enter Numbers only for latitude');
			$('.error').show();
			return false;
    	}
		if(longitude==''){
			$('.error').html('Please enter longitude');
			$('.error').show();
			return false;
		}else if(!numericReg.test(longitude)){
       		$('.error').html('Please enter Numbers only for longitude');
			$('.error').show();
			return false;
    	}*/
		
	});
});

 </script>
 
<div class="module" id="module" style="display:block;">
    <h2><span>Edit Winery Details</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/wineries/update/" enctype="multipart/form-data"  method="post" id="form1">
      <input type="hidden" name="winery_id" value="<?php echo $data[0]['id'];?>"  />
      <table>
      <tr>
          <td align="left" >  Winery Name : </td>
          <td><input type="text" name="name" id="name" value="<?php echo $data[0]['user_name']; ?>"  /></td>
      </tr>
      
      <tr>
		<td align="left" >  Select Association : </td> 
        <td><select name="associations" id="associations" onchange="document.getElementById('association_id').value=this.value" ><?php foreach($association as $name){  ?>
          <option value="<?php echo $name['association_id'];?>" selected="selected" > &nbsp; <?php echo $name['association_name'];?> &nbsp; </option>
		  <?php } ?>
          </select>
        </td>
      </tr>
          <input type="hidden" name="association_id" id="association_id" value="<?php echo $name['association_id'];?>"  />
      
      <tr>
          <td align="left" >  Password : </td>
          <td><input type="text" name="password" id="password" value="<?php echo base64_decode($data[0]['password']); ?>"  /></td>
      </tr>
      
      <tr>
          <td align="left" >  Country : </td>
          <td><input type="text" name="country" id="country" value="<?php echo $data[0]['country'];?>"  /></td>
      </tr>
      <tr>
          <td align="left" >  Province : </td>
          <td><input type="text" name="province" id="province" value="<?php echo $data[0]['province'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" >  Address : </td>
          <td><textarea cols="20" rows="5" id="address" name="address" maxlength="120" ><?php echo $data[0]['address'];?> </textarea></td>
      </tr>
      <tr>
          <td align="left" >  Person Contact : </td>
          <td><input type="text" name="contact" id="contact" value="<?php echo $data[0]['contact'];?>"   /></td>
      </tr>
      <tr>
          <td align="left" >  Web Link : </td>
          <td><input type="text" name="link" id="link" value="<?php echo $data[0]['link'];?>"  /></td>
      </tr>
      <tr>
          <td align="left" valign="top">  Description : </td>
          <td><textarea cols="20" rows="5" id="description" name="description" maxlength="120" ><?php echo $data[0]['description'];?> </textarea>
         </td>
      </tr>

      <tr>
          <td align="left" valign="top">  Notes : </td>
          <td><textarea cols="20" rows="5" id="notes" name="notes" maxlength="120" ><?php echo $data[0]['notes'];?> </textarea>
          </td>
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