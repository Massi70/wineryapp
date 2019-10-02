<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		var discount = $('#discount').val();
		var status = $('#status').val();
		var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
		$('.error').hide();

		if(discount== ''){
			$('.error').html('Please Enter Discount Ratio ');
			$('.error').show();
			return false;
		}else if(!numericReg.test(discount)){
       		$('.error').html('Please enter Numbers only for Discount Ratio');
			$('.error').show();
			return false;
    	}else if (discount == 0 || discount >99 || discount <1){
       		$('.error').html('Discount be greater than 0 and Less than 100');
			$('.error').show();
			return false;
		}

		if(status== ''){
			$('.error').html('Please Select Any Status ');
			$('.error').show();
			return false;
		}
		
	});
});

</script>

<form id="form1" name="form1" action="<?php echo base_url();?>admin/couponcodes/addCouponCode" method="post" >
<div class="container_12">
  <div class="module">
    <h2><span>Add New Coupon</span></h2>
    <div class="module-table-body">   
       <span class="error" style="color:#F00"> </span>
      <table id="myTable" class="tablesorter"  >
        <tbody>
           <tr>
            <td><strong>Coupon Code</strong></td>
            <td>
            <?php $time=time();
			echo  $time;?>
            <input  type="hidden" name="coupon_code" id="coupon_code" value="<?php echo $time; ?>" style="width: 25%;" /></td>
          </tr>
          <tr>
            <td><strong>Discount Ratio</strong></td>
            <td>
            
            <input type="text" name="discount" id="discount" value="" style="width: 25%;" />&nbsp;<b>%</b></td>
          </tr>
          <tr>
            <td><strong>Status</strong></td>
            <td>
            <select name="status" id="status">
            	<option value="">Select Any</option>
            	<option value="1">Activate</option>
                <option value="0">Deactivate</option>
            </select>
             </td>
          </tr>
         </tbody>
      </table>
      <div style="clear: both"></div>
    </div>
    
    <div style="clear: both"></div>
  </div>
  <!-- End .module-table-body -->
</div>
</div>
<div style="clear: both"></div>
<div align="center">
 
<input type="submit" class="submit-green" name="submit" id="submit" value="Save Content" />
</div>
</form>