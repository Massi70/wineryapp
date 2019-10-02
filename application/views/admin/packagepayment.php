<script>
$(document).ready(function(){
	$('#form1').submit(function(){
	
		if(trim($(this).find('#key').val())!=''){
			
			ajax('<?php echo base_url();?>admin/packagepayment/?t=1','main_div','form1','spinner');
			return false;
		}
		//return false;
	});
});
</script>
<script>
function edit(){
	//alert('fghfdg');
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
}
$('a[id^="id"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('id',''));
top.location="<?php echo base_url();?>index.php/admin/packagepayment/edit?id="+id;
});
</script>
<script>
 $(document).ready(function(){
	$('#form2').submit(function(){
	var name = $('#name').val();
	var file = $('#file').val();
	var colors = $('#colorpickerField1').val();
	$("#message").html("<img src='ajax-loader.gif' /> checking...");
	$('.error').hide();
	console.log(name);
	if(name==''){
		$('.error').html('Please Enter Association Name ');
		$('.error').show();
		return false;
	}
	
	if(file==''){
		$('.error').html('Please Upload Image ');
		$('.error').show();
		return false;
	}
	
	if(colors==''){
		$('.error').html('Select unique Color ');
		$('.error').show();
		return false;
	}
	
	
	});
 });
 
</script>
<script>
	function test(){
		//alert('hi');
		var msg = confirm("Do you want to delete??");
		if(msg == true){
			return true;
		}else
		{
			return false;
		}
	}

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
  <div align="right">

</div>
  <!-- Example table -->
  <!--<div style="float:left"><a href="#_" onclick="edit();">Update Package Payment </a></div> 
-->
  <div class="module" id="module1" style="display:none">
    <h2><span>Update Package Payment</span></h2>

  	 	<form name="form2" id="form2" action="<?php echo base_url();?>index.php/admin/packagepayment/update/" method="POST" enctype="multipart/form-data" >
      <br /><br />
      <span class="error" style="color:#F00"> </span>
      <br />
     <tr>
         <td><b> Association Name : </b></td>
         <td><input type="text" id="name" name="name" /></td>
     </tr>
	<br /><br  />
    <tr>
        <td><b>Upload Image : </b></td>
        <td><input type="file" name="file" id="file"  /></td>
     </tr>
    <br />
    <br />
	<tr>
    <td><b>Select Any Color : </b></td>    
    <td><input type="text" maxlength="6" size="6" name="colorpickerField1" id="colorpickerField1" value="00ff00" /></td>
    </tr>
     <br />
    <br />
     <tr>
         <td>&nbsp;</td>
         <td>&nbsp;<input class="submit-green" type="submit" value="Upload" name="submit" /></td>
     </tr>
<br />
<br />
      
      </form>
     
 	<!--	<form name="form3" id="form3" action="<?php //echo base_url();?>index.php/admin/association/" 
        method="POST" enctype="multipart/form-data" >
      
     <tr>
     <?php //$i=1;
	// for($i=1;$i<=3;$i++){
	 ?>
        <br /><td>&nbsp;<b>Upload Image <?php// echo $i; ?>: </b></td>
        <td><input type="file" name="file<?php //echo $i;?>" id="file<?php// echo $i; ?>"  /></td>
     </tr>
<?php //} ?>
    
     <tr>
         <td>&nbsp;</td>
         <td><input type="submit" value="Upload" name="submit" /></td>
     </tr>

      
      </form>
-->      </div>
 <div class="module" id="module">
    <div class="module-table-body">
      
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="20%" style="width:2%;background-image:none !important" >S.No </th>
              <th width="30%"  style="background-image:none !important">Payment Package </th>
              <th width="10%"  style="background-image:none !important">Action</th>
              
            </tr>
          </thead>
          <tbody>
            <?php //echo '<pre>';print_r($data);exit;
					if(count($data)>0){
						$i=1;
						foreach($data as $val){ 
						
					?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              <td class="align-center"><?php echo $val['payment_total']; ?></td>
   				<td class="align-center"> <a href="<?php echo base_url();?>index.php/admin/packagepayment/edit/?id=<?php echo $val['id'];?>"> Update </a></td>
            </tr>
            
            <?php $i++; 
						}
					}else{
						
						?>
						 <tr>
              <td colspan="3">No data found</td>
              
            </tr>
						<?php
					}	
			?>
          </tbody>
        </table>
         <div class="pagination" style="float:right;" > <?php //echo $paging; ?>
       <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>
