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
  <?php //if(isset($msg)) echo $msg; ?>
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
            <?php //echo "<pre>";print_r($eventNotGoing);exit;
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val){ 
			?>
<div id="image"><img src="<?php echo $val['image']; ?>" height="150px" width="150px" />
<br />
<a href="<?php echo base_url();?>admin/events/editImage/?id=<?php echo $val['event_id']; ?>" > Change Image </a>
</div>
<div id="apDiv4"><table width="100%" height="111" class="tablesorter" id="myTable" >
<tbody>
	<tr>
    	<th>Event Name : </th>
    	<th><?php echo $val['event_name']  ; ?></th>
    </tr>
	<tr>
    	<th>Description : </th>
    	<th><?php echo $val['description']  ; ?></th>
    </tr>
	<tr>
    	<th>Venue : </th>
    	<th><?php echo $val['venue']  ; ?></th>
    </tr>
	<tr>
    	<th>Time Date : </th>
 	    <th><?php echo $val['timedate']  ; ?></th>
    </tr>
    <tr>
	    <th>Flavour : </th>
	    <th><?php echo $val['flavour']  ; ?></th>
    </tr>
	<tr>
    	<th>Entry Fee : </th>
    	<th><?php echo $val['entry_fee']  ; ?></th>
    </tr>
    <tr>
   	 	<th>Contact : </th>
   	 	<th><?php echo $val['contact']  ; ?></th>
    </tr>
	<tr>
    	<th>Web Link : </th>
    	<th><?php echo $val['link']  ; ?></th>
    </tr>
	<tr>
    	<th>Email : </th>
    	<th><?php echo $val['email']  ; ?></th>
    </tr>
	<tr>
    	<th>Phone : </th>
    	<th><?php echo $val['phone']  ; ?></th>
    </tr>
   <tr>
        <th>Going</th>
        <th><?php echo $eventGoing[0]['total']  ; ?></th>
    </tr>
    <tr>
        <th>Not Going</th>
        <th><?php echo $eventNotGoing[0]['total']  ; ?></th>
    </tr>
    <tr>
    <td> <a href="<?php echo base_url();?>admin/events/?id=<?php echo $val['winery_id']; ?>" >Back to Events </a></td>
     <td> <a href="<?php echo base_url();?>admin/events/edit/?id=<?php echo $val['event_id']; ?>" >Edit / </a>
      <input type="hidden" name="event_id" value="<?php echo $val['event_id'];?>"  />
          <!-- <a href="<?php //echo base_url();?>admin/wineries/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
        <a href="<?php echo base_url();?>admin/events/delete/?id=<?php echo $val['event_id']; ?>" onclick="return confirm('Are you sure to delete this Event?');"> Expire </a><?php ?></th>
    </tr>
    

</table></div>
      
        
            <?php $i++; 
						}
					}else{
			?>
	    <tr align="center">
              <td colspan="9">No data found</td>
        </tr>
			<?php
					}	
			?>
          </tbody>
        </table>
      </form>
  <!--    <div class="pagination" style="float:right;" > <?php //echo $paging; ?>
    <div style="clear: both;"> </div>
  </div>
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
<!--  </div> -->
  <!-- End .module -->
<!-- </div> -->