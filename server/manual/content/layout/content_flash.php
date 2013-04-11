<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php include('../../template.php'); ?>
<html>
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  	<title><?php echo PRODUCT_NAME; ?> Documentation</title>
  	<link rel="stylesheet" type="text/css" href="../../css/doc.css">
	<meta name="keywords" content="digital signage, signage, narrow-casting, <?php echo PRODUCT_NAME; ?>, open source, agpl" />
	<meta name="description" content="<?php echo PRODUCT_NAME; ?> is an open source digital signage solution. It supports all main media types and can be interfaced to other sources of data using CSV, Databases or RSS." />
  	<link href="img/favicon.ico" rel="shortcut icon">
  	<!-- Javascript Libraries -->
  	<script type="text/javascript" src="lib/jquery.pack.js"></script>
  	<script type="text/javascript" src="lib/jquery.dimensions.pack.js"></script>
  	<script type="text/javascript" src="lib/jquery.ifixpng.js"></script>
</head>

<body>
	<a name="Flash" id="Flash"></a><h2>Flash</h2>
	<p>You can upload your Flash swf files to show on a <?php echo PRODUCT_NAME; ?> layout.</p>

<blockquote>
	<p>Add a Flash File</p>

	<ul>
		<li>Click the "Add Flash" icon</li>
		<li>A new dialogue will appear:

		<p><img alt="Ss_layout_designer_add_flash" src="Ss_layout_designer_add_flash.png"
		style="display: block; text-align: center; margin-left: auto; margin-right: auto"
		width="458" height="288" border="1px"></p></li>
		
		<li>Click "Browse"</li>
		<li>Select the Flash file you want to upload from your computer. Click OK</li>
		<li>While the file uploads, give the flash file a name for use inside <?php echo PRODUCT_NAME; ?>. Type the name in the "Name" box.</li>
		<li>Finally enter a duration in seconds that you want the flash file to play for.<br />
		<i>Note that if this is the only media item in a region, then this is the minimum amount of time the presentation will be shown 
		    for as the total time shown will be dictated by the total run time of the longest-running region on the layout.</i></li>
		    
		<li>Click "Save"<br />
			<i>Note that the C# control used in the <?php echo PRODUCT_NAME; ?> .net client cannot render the background of Flash files transparently. 
			Flash is always rendered on a white background.</i></li>
	</ul>
</blockquote>

	<?php include('../../template/footer.php'); ?>
</body>
</html>
