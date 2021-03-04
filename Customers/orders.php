<?php
session_start();

if(!$_SESSION['user_email'])
{

    header("Location: ../index.php");
}

?>

<?php
 include("config.php");
 extract($_SESSION); 
		$stmt_edit = $DB_con->prepare('SELECT * FROM customer WHERE c_email =:user_email');
		$stmt_edit->execute(array(':user_email'=>$user_email));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		
		?>
		
		<?php
 include("config.php");
		  $stmt_edit = $DB_con->prepare("select sum(order_total) as total from orderdetails where user_id=:user_id and order_status='Ordered'");
		$stmt_edit->execute(array(':user_id'=>$user_id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		
		?>
		

		<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Services</title>
	 <link rel="shortcut icon" href="../assets/img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/local.css" />
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Urban Services</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <!-- LEFT NAV  -->
                <div class="navbar-left">
                <ul class="navbar-nav-left" id="menu_bar">
                    <li class="nav-item"><a class="nav-link" href="index.php"> &nbsp; <i class='glyphicon glyphicon-home'></i><span class="link-text"> Home</span></a></li>
					<li class="nav-item"><a class="nav-link" href="shop.php?id=1"> &nbsp; <i class='glyphicon glyphicon-shopping-cart'></i><span class="link-text"> Book Now</span></a></li>
					<li class="nav-item"><a class="nav-link" href="cart_items.php"> &nbsp; <i class='fa fa-cart-plus'></i><span class="link-text"> Order Cart</span></a></li>
					<li class="nav-item"><a class="nav-link" href="orders.php"> &nbsp; <i class='glyphicon glyphicon-list-alt'></i><span class="link-text"> My Booked Services</span></a></li>
					<li class="nav-item"><a class="nav-link" href="view_purchased.php"> &nbsp; <i class='glyphicon glyphicon-eye-open'></i><span class="link-text"> Order History</span></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#setAccount"> &nbsp; <i class='fa fa-gear'></i><span class="link-text"> Account Settings</span></a></li>
					<li class="nav-item"><a class="nav-link" href="logout.php"> &nbsp; <i class='glyphicon glyphicon-off'></i><span class="link-text"> Logout</span></a></li>                    
                </ul>
                </div>
               

                <!-- TOP NAV -->
                <ul class="nav navbar-nav navbar-right navbar-user">
                    <!-- <li class="dropdown messages-dropdown">
                        <a href="#"><i class="fa fa-calendar"></i>  <?php
                            // $Today=date('y:m:d');
                            // $new=date('l, F d, Y',strtotime($Today));
                            // echo $new; ?></a>
                        
                    </li> -->
					<li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class='glyphicon glyphicon-shopping-cart'></span> Total Price Ordered: &#8369; <?php echo $total; ?> </b></a>
                       
                    </li>
					
					
                     <!-- <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php //echo $user_email; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" data-target="#setAccount"><i class="fa fa-gear"></i> Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </nav>
        <div id="page-wrapper">
            
			
			<div class="alert alert-default" style="color:white;background-color:#008CBA">
         <center><h3> <span class="glyphicon glyphicon-list-alt"></span> My Ordered Items</h3></center>
        </div>
			
			<br />
						  
						  <div class="table-responsive">
            <table class="display table table-bordered" id="example" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Price</th>
				  <th>Quantity</th>
				  <th>Total</th>
                  
                 
                </tr>
              </thead>
              <tbody>
			  <?php
include("config.php");
 
	$stmt = $DB_con->prepare("SELECT * FROM orderdetails where order_status='Ordered' and user_id='$user_id'");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			
			
			?>
                <tr>
                  
                 <td><?php echo $order_name; ?></td>
				 <td>&#8369; <?php echo $order_price; ?> </td>
				 <td><?php echo $order_quantity; ?></td>
				 <td>&#8369; <?php echo $order_total; ?> </td>
				 
				 
                </tr>

               
              <?php
		}
		 include("config.php");
		  $stmt_edit = $DB_con->prepare("select sum(order_total) as totalx from orderdetails where user_id=:user_id and order_status='Ordered'");
		$stmt_edit->execute(array(':user_id'=>$user_id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		
		echo "<tr>";
		echo "<td colspan='3' align='right'>Total Price Ordered:";
		echo "</td>";
		
		echo "<td>&#8369; ".$totalx;
		echo "</td>";
		
		
		
		echo "</tr>";
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
		echo "<br />";
		echo '<div class="alert alert-default" style="background-color:#033c73;">
                       <p style="color:white;text-align:center;">
                       &copy 2016 Urban Services| All Rights Reserved |  Design by : EDGE Team

						</p>
                        
                    </div>
	</div>';
	
		echo "</div>";
	}
	else
	{
		?>
		
			
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Item Found ...
            </div>
        </div>
        <?php
	}
	
?>
			
			
			
			
		
		
		
					
                </div>
            </div>

           

           
        </div>
		
		
		
    </div>
    <!-- /#wrapper -->

	<div class="modal fade" id="setAccount" tabindex="-1" role="dialog" aria-labelledby="myMediulModalLabel">
    <div class="modal-dialog modal-sm">
        <div style="color:white;background-color:#008CBA" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h2 style="color:white" class="modal-title" id="myModalLabel">Account Settings</h2>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="post" action="settings.php">
                    <fieldset>
                        <p>Name:</p>
                        <div class="form-group">
                            <input class="form-control" placeholder="Name" name="c_name" type="text"
                                value="<?php  echo $c_name; ?>" required>
                        </div>
                        <p>Address:</p>
                        <div class="form-group">
                            <input class="form-control" placeholder="Address" name="c_add" type="text"
                                value="<?php  echo $c_add; ?>" required>
                        </div>
                        <p>City:</p>
                        <div class="form-group">
                            <input class="form-control" placeholder="City" name="c_city" type="text"
                                value="<?php  echo $c_city; ?>" required>
                        </div>
                        <p>Mobile:</p>
                        <div class="form-group">
                            <input class="form-control" placeholder="Mobile" name="c_contact" type="text"
                                value="<?php  echo $c_contact; ?>" required>
                        </div>
                        <p>Password:</p>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password"
                                value="<?php  echo $password; ?>" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control hide" name="c_email" type="text" value="<?php  echo $user_email; ?>"
                                required>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">

                <button class="btn btn-block btn-success btn-md" name="user_save">Save</button>

                <button type="button" class="btn btn-block btn-danger btn-md" data-dismiss="modal">Cancel</button>


                </form>
            </div>
        </div>
    </div>
</div>
	  	  <script>
   
    $(document).ready(function() {
        $('#priceinput').keypress(function (event) {
            return isNumber(event, this)
        });
    });
  
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
</script>
</body>
</html>
