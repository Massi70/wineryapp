<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	var file = $('#file').val();
	$('.error').hide();
		//alert('hi');

		if(file==''){
			$('.error').html('Please Upload an Image');
			$('.error').show();
			return false;
		}
	});
});

 </script> 

<?php //echo "<pre>";	print_r($data);
foreach($data as $image){  ?>
<div class="module" id="module" style="display:block;">
    <h2><span>Update Tour Operator Image</span></h2>
    <div class="module-table-body">
    <span class="error" style="color:#F00"> </span>
      <form action="<?php echo base_url()?>admin/touroperators/editPicture/" enctype="multipart/form-data"  method="post" id="form1">
      <table>
      <tr>
          <td align="left" >  Image : </td>
          <td><input type="file" name="file" id="file"  /></td>
      </tr>
<input type="hidden" name="id" id="id" value="<?php echo $image['id'];?>"  />
<?php } ?>
      
      <tr>
      <td></td>
      		<td><input type="submit" name="submit" value="Upload"></td>
      </tr>
     </table>
      </form>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  <!-- End .module -->