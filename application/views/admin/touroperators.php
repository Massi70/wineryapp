<script>
$(document).ready(function(){
	$('#form1').submit(function(){
		if(trim($(this).find('#key').val())!=''){
			ajax('<?php echo base_url();?>admin/addOperator?t=1','main_div','form1','spinner');
			return false;
		}
		return false;
	});
});

</script>
<script>
function addWine()
{
	$('#module1').toggle("slow");
	$('#module').toggle("slow");
}
$('a[id^="id"]').live("click",function(){
var id = parseInt($(this).attr('id').replace('id',''));
top.location="<?php echo base_url();?>index.php/admin/touroperators/addOperator?id="+id;
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
   <div style="float:left"><a href="<?php echo base_url();?>admin/touroperators/addOperator/">Add New Tour Operator </a></div> 
  <div class="module">
		<ul id="navinline">
                <li <?php if($appType == 'all') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/touroperators/?type_id=all">All Tour Operators</a></li>
                <li <?php if($appType == '1') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/touroperators/?type_id=1">British Columbia</a></li>
                <li <?php if($appType == '2') echo 'id="current"';?>><a href="<?php echo base_url();?>admin/touroperators/?type_id=2">Ontario</a></li>
        </ul>

    <h2><span>Tour Operators List</span></h2>

    <div class="module-table-body">

      <form action="">

        <table width="100%" height="111" class="tablesorter" id="myTable">

          <thead>

            <tr>

              <th width="10%" style="width:2%;background-image:none !important" > S.No  </th>
              <th width="13%"  style="background-image:none !important">Operator Name</th>
              <th width="13%"  style="background-image:none !important">Email</th>
              <th width="13%"  style="background-image:none !important">Address</th>
              <th width="13%"  style="background-image:none !important">Province</th>
              <th width="13%"  style="background-image:none !important">Country</th>
              <th width="13%"  style="background-image:none !important">Contact</th>
              <th width="13%"  style="background-image:none !important">Actions</th> 
            </tr>
          </thead>
          <tbody>
            <?php
					if(is_array($data) && count($data)>0){

						$i=1;

						foreach($data as $val){ 

					?>

            <tr>

              <td class="align-center"><?php echo $i; ?></td>

              <td><?php echo $val['user_name']  ; ?></td>
              <td><?php echo $val['user_email']  ; ?></td>
              <td><?php echo $val['address']  ; ?></td>
              <td><?php echo $val['province']  ; ?></td>
              <td><?php echo $val['country']  ; ?></td>
              <td><?php echo $val['contact']  ; ?></td>
              
             <td> <!-- <a href="<?php //echo base_url();?>admin/wineries/edit/?id=<?php //echo $val['winery_id']; ?>" >Edit / </a> -->
               <a href="<?php echo base_url();?>admin/touroperators/view/?id=<?php echo $val['id']; ?>" > View Details / </a>

               <a href="<?php echo base_url();?>admin/touroperators/delete/?id=<?php echo $val['id']; ?>" onclick="return confirm('Are you sure to delete this Tour Operator?');">Delete</a><?php ?></td> 
             <!--  	<a href="<?php// echo base_url();?>admin/touroperators/?id=<?php //echo $val['winery_id']; ?>" >View Events </a></td> -->


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

      <div class="pagination" style="float:right;" > <?php echo $paging; ?>

    <div style="clear: both;"> </div>

  </div>

     

      <div style="clear: both"></div>

    </div>


    <!-- End .module-table-body --> 

  </div>

  <!-- End .module -->

</div>