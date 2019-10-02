	<link rel="stylesheet" href="<?php echo base_url();?>css/colorpicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>admin/css/layout.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/colorpicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url();?>admin/css/layout.css" />
	
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/eye.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/utils.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/layout.js?ver=1.0.2"></script>

 <script>
	$('#colorpickerHolder').ColorPicker({flat: true});
  </script>
<script>
 $(document).ready(function(){
	$('#button1').click(function(){
	var association_id = $('#association_id').val();
	var name = $('#name').val();
	var colors = $('#colorpickerField1').val();
	$("#message").html("<img src='ajax-loader.gif' /> checking...");
	
	if(name==''){
		$('.error').html('Please Enter Association Name ');
		$('.error').show();
		return false;
	}
	if(colors==''){
		$('.error').html('Select Any Unique Color ');
		$('.error').show();
		return false;
	}else{
			$.ajax({
			type:"post",
			url:'<?php echo base_url();?>admin/association/checkColorUpdate/'+colors+'/'+association_id,
			beforeSubmit:function(){
				},
			complete:function(){
				},
			success:function(data){
				//alert(data);
					if(data=='false')
					{
						document.form2.submit();
						//return true;
					}
					else
					{
						$('#color_arleady_exist').html('Color already exists');
						
					}
				}
			});	
			return false;
		}
	});
 });
 
</script>

<script>
   $('#colorpickerField1').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
</script>
				
<script>
$('#colorSelector').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorSelector div').css('backgroundColor', '#' + hex);
	}
});
</script>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php //if(isset($msg)) echo $msg;
  //echo '<pre>';print_r($data);exit; ?>

  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
 <!-- <a href="javascript:;" onclick="simpleAjaxPaging('<?php //echo base_url();?>admin/users/downloadCsv/','test_div','','download_spinner',0);" class="button"> <span>Download CSV</span> </a>-->
  </div>
  <div class="module" >
    <h2><span>Edit Association Details</span></h2>
        <form name="form2" id="form2" action="<?php echo base_url();?>admin/association/update/" method="POST" >
        <input type="hidden" name="association_id" id="association_id" value="<?php echo $data[0]['association_id'];?>"  />
     <br />
     <table width="100%" height="111" class="tablesorter" id="myTable">   
  <tbody>
     <center>
  	 	<span class="error" style="color:#F00" id="color_arleady_exist"></span>
     </center>
     <tr>
         <td><b> Association Name : </b></td>
         <td><input type="text" id="name" name="name" value="<?php echo $data[0]['association_name']; ?>" maxlength="30" /></td>
     </tr>

   	<tr>
    <td><b>Select Any Color : </b></td>    
    <td><input type="text" maxlength="6" size="6" name="colorpickerField1" id="colorpickerField1" value="<?php echo $data[0]['color']; ?>" /></td>
    </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;<input class="submit-green" type="button" value="Upload" id="button1" name="button1" /></td>
     </tr>
	</tbody>
	</table>      
     
   </table>  
    </form> 
    </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>
