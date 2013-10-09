<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>Comet Demo inside test folder</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" / >
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 </head>

 <body>
 <div id="comet_frame" style="display:none;visablity:invisable;"></div>
 <div id="content"></div> <br />
 </body>
</html>
<script type="text/javascript">
 var test={
 
	load: function()
     {
      $("#comet_frame").html('<iframe id="comet_iframe" src="server.php"></iframe>');
     },
	clearFrame: function()
     {
      $("#comet_iframe").html("");
     },
    disp: function(result)
     {
      $("#content").html(result);
     }
 }
 $(document).ready(function()
   { 
    
 test.load();
   });
   </script>
