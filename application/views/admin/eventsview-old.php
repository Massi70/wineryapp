<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php echo base_url();?>admin/wineries/','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});
</script>

<div id="test_div" style="width:0px;height:0px;"></div>
<div class="grid_12">
  <?php if(isset($msg)) echo $msg; ?>
  <!-- Button -->
  <div class="float-right" style="margin-top:20px;"> 
  <span id="download_spinner" style="display:none;">Please Wait...</span>
  <?php /*?> <a href="javascript:;" onclick="simpleAjaxPaging('<?php echo base_url();?>admin/add/downloadCsv/','test_div','','download_spinner',0);" class="button"> <span>Download CSV</span> </a> <?php */?></div>
  <br clear="all" />
    <br clear="all" />
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
  <!-- Example table -->
  <div class="module">
    <h2><span>Event Details</span></h2>
    <div class="module-table-body">
      <form action="">
  		<table width="100%" height="111" class="tablesorter" id="myTable" >
              <th width="4%" style="width:2%;background-image:none !important" >#</th>
              <th width="8%"  style="background-image:none !important">Event Name</th>
              <th width="8%"  style="background-image:none !important">Description</th>
              <th width="8%"  style="background-image:none !important">Image</th>              
              <th width="8%"  style="background-image:none !important">Contact Person</th>              
              <th width="8%"  style="background-image:none !important">Web Link</th>              
              <th width="8%"  style="background-image:none !important">Email</th>              
              <th width="8%"  style="background-image:none !important">Phone Number</th>              
              <th width="8%"  style="background-image:none !important">Actions</th> 
            </tr>
          </thead>
          <tbody>
            <?php //print_r($data1);
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){ 
			?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              <td><?php echo $val['event_name']  ; ?></td>
              <td><?php echo $val['description']  ; ?></td>
              <td><img src="<?php echo $val['image']; ?>" height="150px" width="150px" /></td>
              <td><?php echo $val['contact']  ; ?></td>
              <td><?php echo $val['link']  ; ?></td>
              <td><?php echo $val['email']  ; ?></td>
              <td><?php echo $val['phone']  ; ?></td>
		<!--	<input type="text" name="winery_id" value="<?php //echo $val['winery_id'];?>"  /> -->
               <td>
               <a href="<?php echo base_url();?>admin/events/edit/?id=<?php echo $val['event_id']; ?>" >Edit / </a>
          <!-- <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
               <a href="<?php echo base_url();?>admin/events/delete/?id=<?php echo $val['event_id']; ?>" onclick="return confirm('Are you sure to delete this Event?');"> Remove </a><?php ?></td>
            </tr>
            <?php $i++; 
						}
					}else{
			?>
			 <tr align="center">
              <td colspan="4">No data found</td>
            </tr>
			<?php
					}	
			?>
          </tbody>
        </table>
      </form>
      <div class="pagination" style="float:right;" > <?php //echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>