<script>
 $(document).ready(function(){
	$('#form2').submit(function(){
	var app_type = $('#app_type').val();
	var user_name = $('#user_name').val();
	var regExpr = /^[a-zA-Z]+$/;
	var letterReg = /^[a-zA-Z0-9 _]*[0-9]+[a-zA-Z0-9 _]*$/;
	var email = $('#user_email').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var wlinkReg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
	var password = $('#password').val();
	var cpassword = $('#confirmpassword').val();
	var contact = $('#contact').val();
	var country = $('#country').val();
	var province = $('#province').val();
	var address = $('#address').val();
	var wlink = $('#link').val();
	var description = $('#description').val();
	var notes = $('#notes').val();
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
		}else if(!letterReg.test(user_name)){
			$('.error').html('Only AlphaNumeric characters for User Name');	
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
		}/*else if(!letterReg.test(address)){
			$('.error').html('Only AlphaNumeric characters for Address');	
			$('.error').show();
			return false;
		}*/

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
		
		if(user_type==''){
			$('.error').html('Please Select Any User Type ');
			$('.error').show();
			return false;
		}
		

	});
});

</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php if(isset($msg)) echo $msg; ?>
  
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
 <!-- <a href="javascript:;" onclick="simpleAjaxPaging('<?php //echo base_url();?>admin/users/downloadCsv/','test_div','','download_spinner',0);" class="button"> <span>Download CSV</span> </a>-->
  </div>
  <br clear="all" />
    <div style="float:left">Total Users (<strong> <?php echo $totalUsers?></strong> )</div>

  <div align="right">
<form id="form1" action="" name="form1" method="post">
<b>Search User (By email address or user name): </b>
<input type="text" id="key" class="input-short required" name="key" value="<?php echo $search;?>"  />
<input type="submit" name="Submit" value="Search" class="submit-green" />
</form>
</div>
  <!-- Example table -->
<br />  
<div style="float:left"><a href="<?php echo base_url();?>index.php/admin/users/addUser/">Add New User </a></div> 

  <div class="module" id="module">
    <h2><span>Users</span></h2>
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="2%" style="width:2%;background-image:none !important" >#</th>
              <th width="19%"  style="background-image:none !important">Profile Picture</th>
              <th width="70%"  style="background-image:none !important">User Details</th>
              <th width="10%"  style="background-image:none !important">Actions</th>
            </tr>
          </thead>
          <tbody>

            <?php 
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){ 
					?>
            <tr style="border-bottom:solid 1px #06F">
              <td class="align-center"><?php echo $i; ?></td>
              <td class="align-center"><img src="<?php echo $val['image']; ?>" height="150px" width="150px" />
              <div style="padding:45px">
            <?php   //if($val['user__id']>0){
						?>
       <!-- <img src="//graph.facebook.com/<?php //echo $val['fb_id'];?>/picture?type=square"   /> -->
        <?php
						//}else{
						//	echo thumbnail(BASEPATH_PATH."/images/user_pictures/".$val['picture'],68,60,base_url()."images/user_pictures/".$val['picture'],'header');	
						//}
              ?>
              </div>
              </td>
              <td>
			  <strong>Name:</strong><?php echo $val['user_name'] ; ?>
              <br clear="all" />
              <strong>Email:</strong><?php echo $val['user_email']; ?>
                <br clear="all" />
              <strong>Country:</strong><?php echo $val['country']; ?>
                <br clear="all" />
              <strong>Province:</strong><?php echo $val['province']; ?>
                <br clear="all" />
              <strong>Address:</strong><?php echo $val['address']; ?>
                <br clear="all" />
              <strong>Link:</strong><?php echo $val['link']; ?>
                <br clear="all" />
              <strong>Description:</strong><?php echo $val['description']; ?>
                <br clear="all" />
               </td>
               <td><a href="<?php echo base_url();?>index.php/admin/users/edit/?id=<?php echo $val['id'];?>"><img src="<?php echo base_url();?>images/edit.png" /></a>
               <a href="<?php echo base_url();?>index.php/admin/users/delete/?id=<?php echo $val['id'];?>" onclick="return confirm('Are you sure to delete this User?');"><img src="<?php echo base_url();?>images/delete1.png" /></a></td>

            </tr>
            <?php $i++; 
						}

					}else{
						
						?>
						 <tr>
              <td colspan="6">No data found</td>
              
            </tr>
						<?php
					}	
			?>
          </tbody>
        </table>
      </form>
      <div class="pagination" style="float:right;" > <?php echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>
