<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php echo base_url();?>admin/wineriesview/','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});
</script>
<style type="text/css">
#image {
	position:relative;
	left:117px;
	top:10px;
	width:129px;
	height:129px;
	z-index:1;
}
#apDiv2 {
	position:;
	left:187px;
	top:0px;
	width:6px;
	height:2px;
	z-index:2;
}
#apDiv4 {
	position:relative;
	left:290px;
	top:-115px;
	width:542px;
	height:275px;
	z-index:3;
}
#apDiv1 {
	position:absolute;
	left:254px;
	top:681px;
	width:713px;
	height:270px;
	z-index:4;
}
</style>
<div id="apDiv1">
<table width="100%" height="111" class="tablesorter" id="myTable" >
<tr>

<?php //echo "<pre>";print_r($data1);
	if(is_array($data1) && count($data1)>0){
		$j=1;
	foreach($data1 as $img)
	{ 
		if($j%4==0)
		{
         ?><img src="<?php echo $img['image']; ?>" width="150px" height="150px"  />
<?php 
		}else
		{
		?>
          <img src="<?php echo $img['image']; ?>" width="150px" height="150px"  />&nbsp;
		<?php
		}
	$j++;
  }

 } ?>
</tr>
</table>
</div>
<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php //if(isset($msg)) //echo $msg; ?>
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
  </div>

    <div style="float:left"></div>
  <div align="right">

</div>
 <div style="float:left"> <a href="<?php echo base_url();?>admin/wineries/?type_id=all">Back To Wineries</a></div> 
  <!-- Example table -->
  <div class="module">
    <h2><span>Wineries Details</span></h2>
    <div class="module-table-body">
      <form action="">
            <?php //echo "<pre>";print_r($data);
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){  
			?>
<div id="image"><img src="<?php echo $val['image']; ?>" height="150px" width="150px" />
<br />
<a href="<?php echo base_url();?>admin/wineries/editImage/?id=<?php echo $val['id']; ?>" > Change Image </a>
</div>

<div id="apDiv4"><table width="100%" height="315" class="tablesorter" id="myTable" >
<tbody>
	<tr>
        <th>Winery Name : </th>
        <th><?php echo $val['user_name']; ?></th>
    </tr>
    
    <tr>
        <th>Association Name : </th>
        <th><?php echo $val['association_name']; ?></th>
    </tr>
    
    <tr>
    	<th>Password : </th>
        <th><?php echo base64_decode($val['password']); ?></th>
    </tr>
	<tr>
        <th>Country : </th>
        <th><?php echo $val['country']  ; ?></th>
    </tr>
	<tr>
        <th>Province : </th>
        <th><?php echo $val['province']  ; ?></th>
    </tr>
	<tr>
        <th>Address : </th>
        <th><?php echo $val['address']  ; ?></th>
    </tr>
    <tr>
        <th>Contact : </th>
        <th><?php echo $val['contact']  ; ?></th>
    </tr>
	<tr>
    <tr>
        <th>WebLink : </th>
        <th><?php echo $val['link']  ; ?></th>
    </tr>
	<tr>
    <tr>
        <th>Contact : </th>
        <th><?php echo $val['contact']  ; ?></th>
    </tr>
	<tr>
        <th>Description : </th>
        <th><?php echo $val['description']  ; ?></th>
    </tr>
	<tr>
        <th>Notes : </th>
        <th><?php echo $val['notes']  ; ?></th>
    </tr>
    
  	<!--<tr>
    <th>Longitude : </th>
    <th><?php //echo $val['longitude']  ; ?></th>
    </tr>

	<tr>
    <th>Latitude : </th>
    <th><?php //echo $val['latitude']  ; ?></th>
    </tr>-->

<tr>
<td height="21">&nbsp; <a href="<?php echo base_url();?>admin/events/?id=<?php echo $val['id']; ?>" >View Events </a></td>
			<input type="hidden" name="winery_id" value="<?php echo $val['id'];?>"  />
               <td>
               <a href="<?php echo base_url();?>admin/wineries/edit/?id=<?php echo $val['id']; ?>" >Edit / </a>
          <!--     <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
               <a href="<?php echo base_url();?>admin/wineries/delete/?id=<?php echo $val['id']; ?>" onclick="return confirm('Are you sure to delete this Winery?');"> Remove </a><?php ?></td>
        </tr>


</table></div>

 			<?php $i++; 
						}
					}else{
			?>
						 <tr align="center">
              <td colspan="4">No data found</td>
</tr>
			<?php
					}	//*/
			?>
            
          </tbody>
        </table> 
</form>
     <!-- <div class="pagination" style="float:right;" > <?php //echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
<!--// </div> //-->
  <!-- End .module -->
<!--// </div> //-->