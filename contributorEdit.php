<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
require_once 'db.php';

if(!isset($_SESSION['use'])){
    header('Location: '. 'error_page.php');
}
if(!isset($_GET['pk'])){
    header('Location: '. 'error_page.php');
}

//editace
if(isset($_POST['update']))
{
    foreach($_POST as $key => $value)
    {
        $_POST[$key]= ($value == '' ? 'NULL' : "'".$value."'");
    }

    $q="UPDATE Prispivatel SET
    jmeno=".$_POST['name'].",
    typ_prispivani=".$_POST['conType'].",
    mesto=".$_POST['city'].",
    ulice=".$_POST['street'].",
    castka=".$_POST['amount']."
    WHERE cislo_prispivatele='".$_GET['pk']."'";

    $res=$db->query($q);
    if(!$res)
        header('Location: '. 'error_page.php');
    else
        header('Location: '. 'contributors.php');
}

if(isset($_POST['delete'])){
    // Mazani zvirete
    $q="DELETE FROM Prispivatel WHERE cislo_prispivatele=".$_GET['pk'];
    $res1=$db->query($q);
    if(!$res1)
        header("Location:"."error_page.php");
    else
        header("Location:"."contributors.php");

}


?>

!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta charset=utf-8>
    <title>ZOOIS</title>
    <link rel="stylesheet" href="style.css" type="text/css" >




</head>


<!-- BODY  -->
<body>

    <!-- Logo  -->
    <img src="logo.png" alt="Logo" style="height:100px;">

    <!-- Side bar -->
    <div id="sidebar">
        <?php require_once 'sidebar.php' ?>
    </div>

    <!-- Header-->
    <div id="header">
        Contributor->Update
    </div>
    <!-- Input form -->

    <!-- Content -->

    <div id="content">
        <!-- Input form -->
        <?php
        $q="SELECT jmeno, typ_prispivani, mesto, ulice, castka FROM Prispivatel WHERE cislo_prispivatele='". $_GET['pk'] ."'";
        $res=$db->query($q);
        $res = $res->fetch_assoc();
        ?>
        <form method="post" name= "inputForm" onsubmit="return validateForm(this.submited);">
            <table class="edit">
                <tr><td>Name:</td><td><input required="" type="text" name="name" placeholder="Name" value= '<?php echo $res["jmeno"]?>'></td></tr>
                <tr><td>Contribution type:</td><td><input  required="" type="text" name="conType" placeholder="Contribution type"  value='<?php echo $res["typ_prispivani"]?>'></td></tr>
                <tr><td>Mesto:</td><td><input type="text" name="city" placeholder="City"  value='<?php echo $res["mesto"]?>'></td></tr>
                <tr><td>Street:</td><td><input type="text" name="street" placeholder="Street"  value='<?php echo $res["ulice"]?>'></td></tr>
                <tr><td>Amount:</td><td><input  required="" type="text" name="amount" placeholder="Amount"  value='<?php echo $res["castka"]?>'></td></tr>
                <tr><td colspan='2'>
                    <button class="update" type="submit"  onclick="this.form.submited=this.value;" name="update" value="Update">Update</button>
                    <button class="delete" type="submit"  onclick="this.form.submited=this.value;" name="delete" value="Delete">Delete</button>
                </td></tr>
            </table>

        </form>

        <script>
        function validateForm(a) {
            if(a=="Delete"){
                return true;
            }
            var x = document.forms["inputForm"]["castka"].value;

            if (isNaN(x) || x < 0 || x == "") {
                alert("Amount is invalid");
                return false;
            }
        }
        </script>

    </div>

</body>


</html>
