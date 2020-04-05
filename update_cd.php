<?php
    session_start();
    require 'dbconfi/confi.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update</title>
        <link rel="stylesheet" href="css_codes/style.css">
    </head>

    <body style="background-color: #dedede">
    <?php require 'header.php' ?>

    <script> btnPress(1) </script>

        <center>
            <h1> Update my Info </h1>
            
            <div class="div1">
            <form  class="form_box" action="update_cd.php" method="POST">

                <label class="label">First Name </label><br>
                <input name = "first_name" type="text" class="input_box" value="<?php echo $_SESSION['first_name']; ?>" required /><br>
                
                <label class="label">Last Name </label><br>
                <input name = "last_name" type="text" class="input_box" value="<?php echo $_SESSION['last_name']; ?>" required/><br>

                <label class="label">NIC number </label><br>
                <input name = "NIC_num" type="text" class="input_box" value="<?php echo $_SESSION['user_nic']; ?>" required/><br>

                <label class="label"> Gender </label><br>
                <input name = "gender" type="text" class="input_box" value="<?php echo $_SESSION['gender']; ?>"required/><br>

                <label class="label">District </label><br>
                <input name = "district" type="text" class="input_box" value="<?php echo $_SESSION['district']; ?>" required/><br>

                <label class="label">Occupation </label><br>
                <input name = "occupation" type="text" class="input_box" value="<?php echo $_SESSION['Occupation']; ?>"required/><br>

                <label class="label">Address </label><br>
                <input name = "address" type="text" class="input_box" value="<?php echo $_SESSION['address']; ?>"required/><br>
                
                <label class="label">Password </label><br>
                <input name="password" type="password" class="input_box" required/><br>
                
                <input name="update_button" type="submit"  value="Update"  class="login_button"><br>
                
                
            </form>

            
            </div>
        <center>
    </body>
</html>

<?php
    $con = mysqli_connect("remotemysql.com","kfm2yvoF5R","4vkzHfeBh6") or die("Unable to connect");
    mysqli_select_db($con,"kfm2yvoF5R");

    if (isset($_POST['update_button'])){

        $user_nic=$_POST['NIC_num'];
        $password=$_POST['password'];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $gender = $_POST["gender"];
        $district = $_POST["district"];
        $occupation = $_POST["occupation"];
        $address = $_POST["address"]; 
        $password = $_POST["password"];

        $query="UPDATE civilian_detail SET first_name='$first_name',last_name='$last_name',gender='$gender',district='$district',Occupation='$occupation',address='$address',password='$password' where NIC_num='$user_nic'";
        $query_run= mysqli_query($con,$query);

        if($query_run){
            header('location:home_page.php');
            echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
        }
        else{
            echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';

        }
    }
?>