<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php echo base_url();?>admin/view/','main_div','form1','spinner');
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
</style>


<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php //if(isset($msg)) //echo $msg; ?>
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
  <?php /*?> <a href="javascript:;" onclick="simpleAjaxPaging('<?php echo base_url();?>admin/add/downloadCsv/','test_div','','download_spinner',0);" class="button"> <span>Download CSV</span> </a> <?php */?></div>
    <div style="float:left"></div>
  <div align="right">
<!--
<form id="form1" action="" name="form1" method="post">
<b>Search Add (By Add Title ): </b>
<input type="text" id="key" class="input-short required" name="key" value="<?php //echo $search;?>"  />
<input type="submit" name="Submit" value="Search" class="submit-green" />
</form>
-->
</div>
 <div style="float:left"> <a href="<?php echo base_url()?>admin/touroperators/?type_id=all">Back To Operators</a></div> 
  <!-- Example table -->
  <div class="module">
    <h2><span>Tour Operator Details</span></h2>
    <div class="module-table-body">
     <!-- <form action="<?php //echo base_url()?>admin/touroperators/editPicture/" enctype="multipart/form-data"  method="post" id="form1"> -->
  <!--//	<table width="100%" height="111" class="tablesorter" id="myTable" >
              <th width="4%" style="width:2%;background-image:none !important" >#</th>
              <th width="8%"  style="background-image:none !important">Wine Name</th>
              <th width="8%"  style="background-image:none !important">Country</th>
              <th width="8%"  style="background-image:none !important">Image</th>              
              <th width="8%"  style="background-image:none !important">Province</th>              
              <th width="8%"  style="background-image:none !important">Address</th>              
              <th width="8%"  style="background-image:none !important">Description</th>              
              <th width="8%"  style="background-image:none !important">Notes</th>              
              <th width="8%"  style="background-image:none !important">Actions</th> 
            </tr>
          </thead>
          <tbody> //-->
            <?php //print_r($data);
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){  
			?>
         <!--   <tr>
              <td class="align-center"><?php //echo $i; ?></td>
              <td><?php// echo $val['wine_name']  ; ?></td>
              <td><?php //echo $val['country']  ; ?></td>
              <td><img src="<?php// echo $val['image']; ?>" height="150px" width="150px" /></td>
              <td><?php// echo $val['province']  ; ?></td>
              <td><?php// echo $val['address']  ; ?></td>
              <td><?php// echo $val['description']  ; ?></td>
              <td><?php //echo $val['notes']  ; ?></td>
			<input type="hidden" name="winery_id" value="<?php //echo $val['winery_id'];?>"  />
               <td>
               <a href="<?php //echo base_url();?>admin/wineries/edit/?id=<?php //echo $val['winery_id']; ?>" >Edit / </a>
          <!--     <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
            <!--   <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php// echo $val['winery_id']; ?>" onclick="return confirm('Are you sure to delete this Wine?');"> Remove </a><?php ?></td>
            </tr>-->
           
            
<div id="image"><img src="<?php echo $val['image']; ?>" height="150px" width="150px" />
<br />
<a href="<?php echo base_url();?>admin/touroperators/editImage/?id=<?php echo $val['id']; ?>" > Change Image </a>
</div>

<div id="apDiv4"><table width="100%" height="111" class="tablesorter" id="myTable" >
<tbody>
	
    <tr>
    <th>Operator Name : </th>
    <th><?php echo $val['user_name']  ; ?></th>
    </tr>
	
    <tr>
    <th>Email : </th>
    <th><?php echo $val['user_email']  ; ?></th>
    </tr>
	
    <tr>
    <th>Address : </th>
    <th><?php echo $val['address']  ; ?></th>
    </tr>
    
    <tr>
    <th>Province : </th>
    <th><?php echo $val['province']  ; ?></th>
    </tr>
    
    <tr>
    <th>Country : </th>
    <th><?php echo $val['country']  ; ?></th>
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
      <td>&nbsp;</td>
      <td><a href="<?php echo base_url();?>admin/touroperators/edit/?id=<?php echo $val['id']; ?>" >Edit / </a>
 <!--    <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
         <a href="<?php echo base_url();?>admin/touroperators/delete/?id=<?php echo $val['id']; ?>" onclick="return confirm('Are you sure to Remove this Tour Operator?');"> Remove </a><?php ?>
      </td>
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
