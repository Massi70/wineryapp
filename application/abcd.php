<!--<form method="post" action="" enctype="multipart/form-data" >
<?php //$i=1;
//for($i=1;$i<4;$i++){
 ?> 
Upload: <input type="file" name="file<?php //echo $i++; ?>"  />
<?php //} ?>
<input type="submit" />
</form>-->
<script type="text/javascript">
var counter = 0;
function init(){
document.getElementById("counter").value=counter;
}
function add(){
counter++;
if (counter > 10){counter = 10;
}
else{
document.getElementById("counter").value=counter;
document.getElementById("addimg").innerHTML+=
    "<input type='file' name='img"+counter+"' /> <br/>";}
}
function remove(){
counter--;
if (counter <= 0){counter = 0;}
document.getElementById("counter").value=counter;
document.getElementById("addimg").innerHTML="";
for (var i=1;i<=counter;i++)
{
document.getElementById("addimg").innerHTML+="<input type='file' name='img"+i+"'>"+"<br>";
}
}
</script>


<body onLoad = "init()">
<button onClick="add()" >Add Photo</button>
<button onClick="remove()" >Remove a Photo</button><br>
<form method="POST" enctype='multipart/form-data'>
<div id="addimg">
</div>
<input type="text" id="counter" name="counter" value="">
<input type="submit" name="submit" value="submit">
</form>


</body>