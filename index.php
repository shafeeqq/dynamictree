<!DOCTYPE HTML>
<html>
<!--
Author : Shafeeq.K.Sidhik
Doha Qatar
-->
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Shafeeq.K.Sidhik" />

	<title>Dynamic Tree Plugin - shafeeq</title>
    <link href="css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="javascripts/tree.plugin.js"></script>
</head>

<body>

<div id="dynamictree">
</div>
<script>
  
    $("#dynamictree").dynamictree({
        lang : 'en',
        theme     : "yellow",
        startfrom  : 0,
        treetype : "hierarchicall" //hierarchical or normal
       
        
    });
</script>





</body>
</html>