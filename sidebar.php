<?php
session_save_path('tmp');
//session_start();
?>
<ul>
    <li style="font-family: helvetica; color:#ffa31a; padding: 2px 16px;"><?php echo $_SESSION['use'] ?></li>
    <li><br></li>
    <li><a href="homePage.php">Home</a></li>
    <li><a href="animals.php">Animals</a></li>

    <li><a href="fences.php">Fences</a></li>



    <?php
    if($_SESSION['priv']==3) # ADMIN
    {
        ?>
        <li><a href="contributors.php">Contributors</a></li>
        <li><a href="staff.php">Staff</a></li>
        <li><a href="assignKeeper.php">Assign to Animal</a></li>


        <?php
    }
    elseif($_SESSION['priv']==2 || $_SESSION['priv']==1) # Hlavni osetrovatel a osetrovatel
    {
        ?>
        <li><a href="personal_schedule.php">Personal schedule</a></li>
        <?php
    }
    else
    {
        header("Location:"."error_page.php");
    }
    ?>


    <li><br><br></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
