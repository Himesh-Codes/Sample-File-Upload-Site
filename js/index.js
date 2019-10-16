function drop(id,loc)
{
  msg = confirm('Are you sure to delete file?');
  var userid = id;
  var fileloc = loc;
  console.log(msg);
  if (msg == true) 
  {
    window.location = "delete.php?valueone="+userid+"&valuetwo="+fileloc;
  }
}