<div class="content">
    <div class="title_area">
        <h1></h1>
        <div class="add_new">
        </div>
    </div>
    <table width="100%" height="315" class="tablesorter" id="myTable" >
        <tbody>
            <tr>
                <th>Name : </th>
                <th><?php echo $val['user_name']  ; ?></th>
            </tr>
            <tr>
                <th>Email : </th>
                <th><?php echo $val['user_email']  ; ?></th>
            </tr>
            <tr>
                <th>City : </th>
                <th><?php echo $val['city']  ; ?></th>
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
            <?php
			if($val['user_type_id']==2)
			{
			?>
            <tr>
                <th>Description : </th>
                <th><?php echo $val['description']  ; ?></th>
            </tr>
            <tr>
                <th>Notes : </th>
                <th><?php echo $val['notes']  ; ?></th>
            </tr>
            <?php
			
			}?>
            
            <tr>
                <th>Longitude : </th>
                <th><?php echo $val['longitude']  ; ?></th>
            </tr>
            <tr>
                <th>Latitude : </th>
                <th><?php echo $val['latitude']  ; ?></th>
            </tr>
             
    </table>
  
</div>
    <a href="<?php echo base_url();?>index/edit/" >
