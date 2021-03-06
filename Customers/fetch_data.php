<?php

//fetch_data.php

include('config.php');

if(isset($_POST["action"]))
{
	$query = "SELECT * FROM service_provider WHERE ";

	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query.= "sp_rate BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'";
	}
	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "AND sp_city IN('".$brand_filter."')";
	}
	
	$stmt_edit = $DB_con->prepare($query);
	$stmt_edit->execute();
	$result = $stmt_edit->fetchAll();
	$total_row = $stmt_edit->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= 
			'
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
					
					<p align="center"><strong><a href="#">'. $row['sp_name'] .'</a></strong></p>
					<h4 style="text-align:center;" class="text-danger" >'. $row['sp_rate'] .'</h4>
					
				</div>

			</div>
			';

			
		  }
		}

			
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;//add pagination
}

?>