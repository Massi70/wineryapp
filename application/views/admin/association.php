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
  <div style="float:left"><a href="<?php echo base_url();?>admin/association/addAssociation" >Add New Association </a></div> 

  
 <div class="module" id="module">
    <div class="module-table-body">
      
        <table width="100%" height="111" class="tablesorter" id="myTable">
          <thead>
            <tr>
              <th width="10%" style="width:2%;background-image:none !important" >S.No </th>
              <th width="20%"  style="background-image:none !important">Association Name </th>
              <th width="20%"  style="background-image:none !important">Color Code </th>
              <th width="25%"  style="background-image:none !important">Image</th>
              <th width="20%"  style="background-image:none !important">Action</th>
              
            </tr>
          </thead>
          <tbody>
            <?php 
					if(count($data)>0){
						$i=1;
						foreach($data as $val){ 
						
					?>
            <tr>
              <td class="align-center"><?php echo $i; ?></td>
              <td class="align-center"><?php echo $val['association_name']; ?></td>
              <td class="align-center"><?php echo $val['color']; ?></td>
              <td class="align-center"> <img src="<?php echo $val['image']; ?>" height="100px" width="150px" /></td>
              <td class="align-center"> <a href="<?php echo base_url();?>index.php/admin/association/delete/?id=<?php echo $val['association_id'];?>" onclick="return test();">Delete </a>&nbsp; <a href="<?php echo base_url();?>index.php/admin/association/edit/?id=<?php echo $val['association_id'];?>">Update </a></td>
            </tr>
            
            <?php $i++; 
						}
					}else{
						
						?>
						 <tr>
              <td colspan="6">No data found</td>
              
            </tr>
						<?php
					}	
			?>
          </tbody>
        </table>
         <div class="pagination" style="float:right;" > <?php echo $paging; ?>
       <div style="clear: both;"> </div>
  </div>
     
      <div style="clear: both"></div>
    </div>
    <!-- End .module-table-body --> 
  </div>
  <!-- End .module -->
</div>
