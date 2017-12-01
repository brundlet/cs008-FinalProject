<?php
	include('top.php');

	$filename = 'data/ids.csv';
	$file = $file = fopen($filename, "r");
	$ids[];
	$dataOK = false;
	if($file){
		$dataOK = true;
		$headers = fgetcsv($file);
		while(!eof($file)){
			$element = fgetcsv($file);
			if($element != "") $ids[] = $element;
		}
		fclose($file);
	}
?>

<article id="content">
	<h3>If you make your data public, it can't be stolen!<h3>
	
	<table>
		<caption>User Submitted Personal Infromation</caption>
		<?php
			if($dataOK){
				//print the headers
				print'<tr>';
				foreach($headers as $head){
					print'<th scope = "col">' .$head. '</th>';
				}
				print'</tr>'.PHP_EOL;
				
				
				//print rows. one per identity
				foreach($ids as $id){
					print'<tr>';
					foreach($id as $data){
						print'<td>'.$data.'</td>';
					}
					print'</tr>'.PHP_EOL;
				}
				
			}//end dataOK
			
		?>
	</table>
	
	<?php
		if(!$dataOK) print'<p>No data to display</p>';
	?>
	
</article>


<?php
	include('footer.php');
?>
