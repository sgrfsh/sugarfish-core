<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>YTHandler Tests</title>

	<style type="text/css">
		body{font-family:Arial,Helvetica,sans-serif;font-size:10px;color:#333;margin:10px;line-height:12px;}
		table{border:1px solid #999;border-collapse:collapse;}
		td{border:1px solid #999;}
	</style>
</head>

<body>

<?php
	include "YTHandler.class.php";

	print '<table>';
		$objYTH = new YTHandler('q5xYGzRJp8U'); // set entity via constructor
		printf('<thead><tr><td>Video ID: (%s) [%s]</td></tr></thead>', $objYTH->EntityType, $objYTH->Count);
		print '<tbody><tr></tr><td><pre>' . print_r($objYTH->Entity, true) . '</pre></td></tr></tbody>';

		$arrVideoIds = array('q5xYGzRJp8U', 'ue-TWz_cDYM', 'uL87MgGs9WU', '_2P0KOchWqw', 'pIr-343e_VE');
		$objYTH->SetEntity($arrVideoIds); // set entity via SetEntity() method
		printf('<thead><tr><td>Array of Video IDs: (%s) [%s]</td></tr></thead>', $objYTH->EntityType, $objYTH->Count);
		print '<tbody><tr></tr><td><pre>' . print_r($objYTH->Entity, true) . '</pre></td></tr></tbody>';

		$objYTH->SetEntity('http://gdata.youtube.com/feeds/api/users/sgrfsh/uploads');
		printf('<thead><tr><td>Channel: (%s) [%s]</td></tr></thead>', $objYTH->EntityType, $objYTH->Count);
		print '<tbody><tr></tr><td><pre>' . print_r($objYTH->Entity, true) . '</pre></td></tr></tbody>';

		$arrChannels = array('http://gdata.youtube.com/feeds/api/users/sgrfsh/uploads');
		$objYTH->SetEntity($arrChannels);
		printf('<thead><tr><td>Array of Channels: (%s) [%s]</td></tr></thead>', $objYTH->EntityType, $objYTH->Count);
		print '<tbody><tr></tr><td>';
		print '<pre>' . print_r($objYTH->Entity, true) . '</pre>';
		print $objYTH->PrintSummary;
		print '</td></tr></tbody>';

		print '<thead><tr><td>Pulling out data directly:</td></tr></thead>';
		print '<tbody><tr></tr><td>';
		print 'using a "foreach":';
		print '<p>';
		foreach ($objYTH->Entity as $arrVideo) {
			print $arrVideo['title'] . '<br />';
		}
		print '</p>';
		print 'using indices:';
		print '<p>';
		print $objYTH->Entity[0]['title'] . '<br />';
		print $objYTH->Entity[0]['thumbnail'];
		print '</p>';
		print '</pre></td></tr></tbody>';
	print '</table>';
?>

</body>
</html>
