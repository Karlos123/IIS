<?php
session_save_path("tmp");
echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
foreach($_POST as $key => $value)
{
    echo "\r\n".$key." ".$value."\r\n";
}
?>

<link rel="stylesheet" href="modalstyle.css" type="text/css" >
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">Close</span>
      <h2>Animal form</h2>
    </div>
    <div class="modal-body">
      <div class='form' action="" method="POST" accept-charset="utf8">
        <form id="animal_form">
          <p class="contact"><label for="name">Animal name</label></p>
          <input id="name" name="name" placeholder="Animal name" required="" tabindex="1" type="text">
          <p class="contact"><label for="name">Gender</label></p>
          <select class="select-style gender" name="gender">
            <option value="select">Select gender</option>
            <option value="m">Male</option>
            <option value="f">Female</option>
            <option value="others">Other</option>
          </select><br><br>
          <p class="contact"><label for="spiece">Speice</label></p>
          <input id="name" name="speice" required="" type="text">
          <p class="contact"><label for="spiece">Weight</label></p>
          <input id="name" name="weight" required="" type="number" step="any" min="0">

          <p class="contact"><label for="name">Birth date</label></p>
          <label>Day<input class="birthday" placeholder="Day" required="" type="number" min="1" max="31"></label>
          <label>Month<input class="birthmonth" placeholder="Month" required="" type="number" min="1" max="12"></label>
          <label>Month<input class="birthyear" placeholder="Year" required="" type="number" min="1900" max="<?php echo date("Y"); ?>"></label>

          <p class="contact"><label for="name">Father</label></p>
          <input id="name" name="father" required="" type="text">

          <p class="contact"><label for="name">Mother</label></p>
          <input id="name" name="mother" required="" type="text">

          <p class="contact"><label for="name">Health</label></p>
          <input id="name" name="health" required="" type="text">

          <p class="contact"><label for="name">Med-check</label></p>
          <label>Day<input class="birthday" placeholder="Day" required="" type="number" min="1" max="31"><?php echo date("d"); ?></label>
          <label>Month<input class="birthmonth" placeholder="Month" required="" type="number" min="1" max="12"><?php echo date("m"); ?></label>
          <label>Month<input class="birthyear" placeholder="Year" required="" type="number" min="1900" max="<?php echo date("Y"); ?>"></label>

          <p class="contact"><label for="spiece">Run</label></p>
          <input id="name" name="run" required="" type="number" min="0">


        </form>

      </div>
    </div>
    <div class="modal-footer">
      <input class="buttom" name="submit" id="submit" tabindex="5" value="Save!" type="submit">

    </div>
  </div>
</div>
<script>
var modal = document.getElementById('myModal');
// Get the button that opens the modal
var btn = document.getElementById("button_add");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
  }
}
</script>
