<?php
/*
sample code to use this script (you may need to change file path though

require_once (dirname(__FILE__) .'../../2009/dgtwc-demo-ui.php');
show_demo_style();
show_demo_header("hello World", "http://data-gov.tw.rpi.edu/dgtwc-demo-ui", "http://data-gov.tw.rpi.edu/wiki","http://data-gov.tw.rpi.edu/wiki/rss");


*/
function show_demo_style(){
?>
<STYLE TYPE="text/css">
<!--
 img { border: 0; }
 
.logoimg{
  height:64px;
  width:64px;
  float:left;
  position:relative;
  margin-right:15px;
  top:-10px;
}
.menuimg{
  height:32px;
  width:32px;
  position:relative;
  top:0px;
  border:0px;
}
.normal {
  font-family:Helvetica,Arial,sans-serif;
  font-size:24px;
  margin:0px 0px 3px 2px;
  padding: 1px;
  display:block;
}
h3 {
  font-family:Arial,Helvetica,sans-serif;
  font-size:16px;
  margin:0px 0px 3px 2px;
  padding: 1px;
  display:block;
}
h2 {
  font-family:Helvetica,Arial,sans-serif;
  font-size:18px;
  margin:0px 0px 3px 2px;
  padding: 1px;
  display:block;
}
h1 {
  font-family:Arial,Helvetica,sans-serif;
  font-size:32px;
  margin:0px 0px 3px 2px;
  padding: 1px;
  display:block;
  color:#333;
}


-->
</STYLE>

<?php
}

function show_demo_header($title, $url_demo,  $url_wiki, $url_rss=null, $url_description="#description"){
?>
<table width="100%">
<tr>
<td width="70%" valign="bottom">

<a href='http://data-gov.tw.rpi.edu' alt='Data-gov Wiki'>
<img src='http://data-gov.tw.rpi.edu/images/logo-data-gov.png' class="logoimg"/></a>

<center>
<h2><?php echo $title ?></h2>
</center>

</td>
<td align="right">

<a class"=info" href="<?php echo $url_demo; ?>">
<img src="http://data-gov.tw.rpi.edu/images/blue_home.png" alt="Go to demo page" class="menuimg"/></a>

   

<a class"=info" href="<?php echo $url_wiki; ?>">
<img src='http://data-gov.tw.rpi.edu/images/blue_info.png' class="menuimg" alt='go to this demo wiki page'/></a>

<!--
<?php if ($url_description)
{
?>
   
<a class"=info" href="<?php echo $url_description; ?>">
<img src='http://data-gov.tw.rpi.edu/images/blue_folder.png' class="menuimg" alt='go to demo description'/></a>
<?php
}
?>
-->

   
<a class"=info" href="mailto:tw-webmaster@tw.rpi.edu">
<img src='http://data-gov.tw.rpi.edu/images/blue_mail.png' class="menuimg" alt='Contact us'/> 
</a>

<?php
if (!empty($url_rss)){
?>
   
<a class"=info" href="<?php echo $url_rss; ?>">
<img src='http://data-gov.tw.rpi.edu/images/rss.png' class="menuimg" alt='subscribe rss'/> 
</a>
<?php
}
?>
</td>
</tr>
</table>
<?php
}
?>
