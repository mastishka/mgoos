<?php include_once('../../lib/mgoos_config.php'); 
$link_crawler=CMGooSConfig::MGOOS_ROOT.'/admin/crawler/crawler_dashboard.php';
$link_citation=CMGooSConfig::MGOOS_ROOT.'/citation_dashboard.php';
echo"<html>
<head>
</head>
<body>
<a href='$link_crawler'>Crawler Dash Board</a><br><br><a href='$link_citation'>Citation Dash Board</a> 
</body>
</html>";
?>


