<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();
if(!isset($_SESSION['use']))
{
    header('Location: '. 'error_page.php');
}
require_once 'db.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta charset="utf-8">
    <title>ZOOIS</title>
    <link rel="stylesheet" href="style.css" type="text/css" >
    <script>
    function row(x) {
        window.location.href= "contributorEdit.php?pk="+document.getElementById("tbl").rows[x.rowIndex].cells[0].innerHTML;
    }
    </script>
</head>


<!-- BODY  -->
<body>

    <!-- Logo  -->
    <img src="logo.png" alt="Logo" style="height:100px;">

    <!-- Side bar -->
    <div id="sidebar">
        <?php require_once 'sidebar.php' ?>
    </div>
    <div id="header">
        Contributors
        <!-- <div id="logged_user">
        <?php echo $_SESSION['use'] ?>
    </div> -->
</div>

<!-- Content -->
<div id="content">
    <form action="contributorAdd.php">
        <button class="add"  type="submit"> Add contributor </button>
    </form>



    <table class="display" id="tbl">
        <tbody>
            <tr>
                <th>N.</th>
                <th>Name</th>
                <th>Contribution type</th>
                <th>City</th>
                <th>Street</th>
                <th>Amount</th>
                <th>Total amount</th>
            </tr><tr></tr>
            <?php
            $q='SELECT * FROM Prispivatel';
            $res=$db->query($q);
            while($row=$res->fetch_assoc())
            {
                echo "<tr onclick='row(this)'>";
                foreach($row as $key => $value)
                {
                    if($value)
                    {
                        echo "<td>".$value."</td>";
                    }
                    else {
                        echo "<td></td>";
                    }

                }
                echo "</tr>";

            }
            ?>




        </div>








    </div>





</body>


</html>
