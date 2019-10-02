<script>
/*
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php //echo base_url();?>admin/wineries/','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});
*/
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
--><?php //echo "<pre>";print_r($data);exit;
//echo $data[0]['winery_id'];?>
</div>
  <!-- Example table -->
 <!--   <div style="float:right"><a href="<?php //echo base_url();?>admin/events/addEvent/">Add New Event</a></div>
    
    <div style="float:left"><a href="<?php //echo base_url();?>admin/wineries/?type_id=all">Back To Wineries</a> -->
    </div>

  <div class="module">

    <h2><span>Events</span></h2>

    <div class="module-table-body">
<?php //echo "<pre>";print_r($data);exit; ?>
      <form action="">

        <table width="100%" height="111" class="tablesorter" id="myTable" border="2">
          <thead>
            <tr>
              <th width="4%" style="width:2%;background-image:none !important" >S.No</th>
              <th width="8%"  style="background-image:none !important">Event Name</th>
              <th width="8%"  style="background-image:none !important">Description</th>
              <th width="8%"  style="background-image:none !important">Venue</th>
              <th width="8%"  style="background-image:none !important">Date Time</th>
              <th width="8%"  style="background-image:none !important">Wine Flavour</th>
              <th width="8%"  style="background-image:none !important">Entry Fee</th>
              <th width="8%"  style="background-image:none !important">Actions</th> 
            </tr>
          </thead>
          <tbody>

            <?php //echo "<pre>";print_r($data);
			//exit;
					if(is_array($data) && count($data)>0){
						$i=1;
						foreach($data as $val1){ 
					?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              <td><?php echo $val1['event_name']  ; ?></td>
              <td><?php echo $val1['description']  ; ?></td>
              <td><?php echo $val1['venue']  ; ?></td>
              <td><?php echo $val1['timedate']  ; ?></td>
              <td><?php echo $val1['flavour']  ; ?></td>
              <td><?php echo $val1['entry_fee']  ; ?></td>
              <td>
              	<a href="<?php echo base_url();?>index/view/?id=<?php echo $val1['event_id']; ?>" >View Details / </a>
          <!--      <a href="<?php //echo base_url();?>admin/events/delete/?id=<?php //echo $val['event_id']; ?>" > / Delete</a> -->
               	<a href="<?php echo base_url();?>index/delete/?id=<?php echo $val1['event_id']; ?>" onclick="return confirm('Are you sure to delete this Event?');">Delete</a><?php ?></td>
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