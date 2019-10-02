<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	
		if(trim($(this).find('#key').val())!=''){
			
			ajax('<?php echo base_url();?>admin/couponcodes/','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});

function deleCouponCodes(id){
	 
	var r=confirm("Are You Sure want to delete this Coupon")
	if (r==true)
	  {
	    window.location = "<?php echo base_url();?>admin/couponcodes/delete/?id="+id
	  }
	 
	 
	}
</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php if(isset($msg)) echo $msg; ?>
  
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
  <a href="<?php echo base_url();?>admin/couponcodes/add/" class="button"> <span>Add New Coupon</span> </a>
  </div>
  <br clear="all" />
    <br clear="all" />
    <div style="float:left"></div>


  <!-- Example table -->
  <div class="module">
    <h2><span>Coupon Codes</span> </h2>
     
    <div class="module-table-body">
      <form action="">
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="4%" style="width:2%;background-image:none !important" >#</th>
              <th width="10%" style="width:2%;background-image:none !important" >Coupon Code</th>
              <th width="10%"  style="background-image:none !important">Creation Date</th> 
              <th width="10%"  style="background-image:none !important">Status</th> 
              <th width="10%"  style="background-image:none !important">Is Charge</th> 
              <th width="10%"  style="background-image:none !important">Action</th> 
             </tr>
          </thead>
          <tbody>
            <?php 
					//echo '<pre>';print_r($data);
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){ 
					?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              
              <td><?php echo $val['code']  ; ?></td>
              <td><?php echo date("d M Y",strtotime($val['creation_date'])); ?></td>
              
              <td><?php
			  if($val['status']==1 )
			  { 
			  	echo "Active";
			  }
			  else
			  {
				echo "Not Active";
			  }
			  
			   ?></td>
              
              <td><?php 
			  		if($val['is_charge']==1 ){ echo "Charged On : ".date("d M Y",strtotime($val['activation_date']))."<br>Charged By : ".$val['user_name']   ; } ?></td>
              
               <td>
               <?PHP
			   if($val['is_charge']==0 ){ 
			   ?>
              <!-- <a href="<?php //echo base_url();?>admin/couponcodes/email/?id=<?php //echo $val['id']; ?>" >Email</a>-->
               <a href="<?php echo base_url();?>admin/couponcodes/edit/?id=<?php echo $val['id']; ?>" >Edit</a>
               
               <a href="javascript:;" onclick="deleCouponCodes(<?php echo $val['id']; ?>);" >Delete</a>
               <?PHP
			   }
			   ?>
			   <?php /*?><a href="<?php echo base_url();?>admin/content/?id=<?php echo $val['id']; ?>" onclick="return confirm('Are you sure to delete this content?');">Remove</a><?php */?></td>
            </tr>
            <?php $i++; 
						}
					
					}else{
						
						?>
						 <tr align="center">
              <td colspan="6">No data found</td>
              
            </tr>
						<?php

					}	
			?>
          </tbody>
        </table>
      </form>
      <div class="pagination" style="float:right;" >
        <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>