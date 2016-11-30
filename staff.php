<?php
header("Content-Type: text/html; charset=UTF-8");
session_save_path("tmp");
session_start();if(!isset($_SESSION['use']))
{
    header('Location: '. 'error_page.php');
}
require_once 'db.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<!-- HEAD  -->
<head>
    <meta charset=utf-8">
    <title>ZOOIS</title>
    <link rel="stylesheet" href="style.css" type="text/css" >
    <script>
        function row(x) {
            window.location.href= "staffEdit.php?pk="+document.getElementById("tbl").rows[x.rowIndex].cells[0].innerHTML;
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
        Staff
    </div>

    <!-- Content -->
    <div id="content">
        <form action="staffAdd.php">
            <button  class="add"  type="submit">Add employee</button>
        </form>



        <table class="display" id="tbl">
            <tbody>
                <tr>
                    <th>N.</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>City</th>
                </tr><tr></tr>
                <?php
                $q='SELECT os_cislo, jmeno, primeni, mesto FROM Osetrovatel';
                $res=$db->query($q);
                while($row=$res->fetch_assoc())
                {
                    echo "<tr onclick='row(this)'>";
                    foreach($row as $key => $value)
                    {
                        if($value)
                        echo "<td>".$value."</td>";
                        else
                        echo "<td></td>";
                    }
                    echo "</tr>";

                }
                ?>




            </div>








        </div>





    </body>


    </html>
