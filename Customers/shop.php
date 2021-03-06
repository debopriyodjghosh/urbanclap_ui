<?php
session_start();

if (!$_SESSION['user_email']) {

    header("Location: ../index.php");
}

?>

<?php
include("config.php");
extract($_SESSION);
$stmt_edit = $DB_con->prepare('SELECT * FROM customer WHERE c_email =:user_email');
$stmt_edit->execute(array(':user_email' => $user_email));
$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($edit_row);

?>
<?php

include "nav.php";?>
        <div id="page-wrapper">
            <div class="alert alert-default" style="color:white;background-color:#008CBA">
                <center>
                    <h3> <span class="glyphicon glyphicon-shopping-cart"></span> This is our well knowned service providers, Book now!</h3>
                </center>
            </div>   
        <div class="alert alert-default">
        	
            <div class="col-md-6">                				
				<div class="list-group">
					<h3>Price</h3>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="5000" />
                    <p id="price_show">100 - 5000</p>
                    <div id="price_range"></div>
                </div>	
            </div>

            <div class="col-md-6">
                    <div class="list-group">
                        <h3>City</h3>
                        <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
                            <?php
                    include("config.php");
                    $query = "SELECT DISTINCT sp_city FROM service_provider";
                    $stmt_edit = $DB_con->prepare('SELECT DISTINCT sp_city FROM service_provider');
                    $stmt_edit->execute(array());
                    $edit_row = $stmt_edit->fetchAll();
                    extract($edit_row);
     
                    foreach($edit_row as $row)
                    {
                    ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector brand"
                                        value="<?php echo $row['sp_city']; ?>"> <?php echo $row['sp_city']; ?></label>
                            </div>
                            <?php
                    }
                    ?>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row filter_data">

                            </div>
        <br />
           <!--list add-->
           <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "urbanclap";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $start = 0;
            $limit = 8;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $start = ($id - 1) * $limit;
            }
            $sql = "select * from service_provider LIMIT $start, $limit";
            $result = $conn->query($sql);
            while ($query2 = $result->fetch_assoc()) {
                echo "<div class='col-sm-3'>
              <div class='panel panel-default' style='border-color:#008CBA;'>
                <div class='panel-heading' style='color:white;background-color : #033c73;'>
                  <center>
                  <strong><textarea style='text-align:center;background-color: #93eacc;' class='form-control' rows='1'
                      disabled>" . $query2['sp_name'] . "</textarea></strong>
                  </center>
                </div>
                <div class='panel-body'>
                <center>
                <h4> Service: " . $query2['s_name'] . " </h4>
              </center>
              <center>
              <h4> Experience: " . $query2['sp_exp'] . " yrs </h4>
            </center>
            <center>
                <h4> City: " . $query2['sp_city'] . " </h4>
              </center>
                <center>
                <h4> Contact: " . $query2['sp_contact'] . " </h4>
              </center>
               <center>
                    <h4> Price: &#8377; " . $query2['sp_rate'] . " </h4>
                  </center>
                  <a class='btn btn-block btn-danger' href='add_to_cart.php?cart=" . $query2['sp_email'] . "'><span
                      class='glyphicon glyphicon-shopping-cart'></span> Add to cart</a>
                </div>
              </div>
            </div>";
            }
            echo "<div class='container'>";
            echo "</div>";
            $sql1 = "select * from service_provider";
            $result1 = $conn->query($sql1);
            $rows = mysqli_num_rows($result1);
            $total = ceil($rows / $limit);
            echo "<br /><ul class='pager'>";
            if ($id > 1) {
                echo "<li><a style='color:white;background-color : #033c73;' href='?id=" . ($id - 1) . "'>Previous Page</a><li>";
            }
            if ($id != $total) {
                echo "<li><a style='color:white;background-color : #033c73;' href='?id=" . ($id + 1) . "' class='pager'>Next Page</a></li>";
            }
            echo "</ul>";
            echo "<center><ul class='pagination pagination-lg'>";
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $id) {
                    echo "<li class='pagination active'><a style='color:white;background-color : #033c73;'>" . $i . "</a></li>";
                } else {
                    echo "<li><a href='?id=" . $i . "'>" . $i . "</a></li>";
                }
            }
            echo "</ul></center>";
            ?>
<br />
 <div class="alert alert-default" style="background-color:#033c73;">
                <p style="color:white;text-align:center;">
                    &copy 2016 Urban Services| All Rights Reserved | Design by : EDGE Team

                </p>

            </div>

        </div>
    </div>




    </div>



    </div>
    <!-- /#wrapper -->
<?php
include "edit_ac.php";
?>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var brand = get_filter('brand');
       
        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider({
        range:true,
        min:100,
        max:5000,
        values:[100, 5000],
        step:100,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>
    <script>
        $(document).ready(function() {
            $('#priceinput').keypress(function(event) {
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