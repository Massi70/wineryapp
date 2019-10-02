<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	var payment_total = $('#payment_total').val();
	var numericReg = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/;
	$('.error').hide();
		//alert('hi');

		if(payment_total==''){
			$('.error').html('Please enter payment_total ');
			$('.error').show();
			return false;
		}else if(!numericReg.test(payment_total)){
       		$('.error').html('Only Numbers For payment_total');
			$('.error').show();
			return false;
    	}
	});
});

 </script> 
 
  <br clear="all" />
    <br clear="all" />

<div class="module" id="module" style="display:block;">
    <h2><span>Update Payment Package</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
    <form action="<?php echo base_url()?>index.php/admin/packagepayment/update/" method="post" id="form1">
     <input type="hidden" name="id" value="<?php echo $data[0]['id'];?>"  />
      <table>
      <tr>
          <td align="left" > Payment Total  : </td>
          <td><input type="text" name="payment_total" id="payment_total" value="<?php echo $data[0]['payment_total']; ?>"  /></td>
      </tr>
      
      <tr>
      <td></td>
      		<td><input class="submit-green" type="submit" name="submit" value="Update"></td>
      </tr>
     </table>
      </form>
     
    <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  <!-- End .module -->