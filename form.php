<link rel="stylesheet" href="formstyle.css" type="text/css" >

<div  class="form">
  <form id="contactform">
    <p class="contact"><label for="name">Name</label></p>
    <input id="name" name="name" placeholder="First and last name" required="" tabindex="1" type="text">
    <p class="contact"><label for="email">Email</label></p>
    <input id="email" name="email" placeholder="example@domain.com" required="" type="email">
    <p class="contact"><label for="username">Create a username</label></p>
    <input id="username" name="username" placeholder="username" required="" tabindex="2" type="text">
    <p class="contact"><label for="password">Create a password</label></p>
    <input type="password" id="password" name="password" required="" type="text">
    <p class="contact"><label for="repassword">Confirm your password</label></p>
    <input type="password" id="password" name="password" required="" type="text">
    <fieldset>
      <label>Birthday</label>
      <label class="month">
        <select class="select-style" name="BirthMonth">
          <option value="">Month</option>
          <option  value="01">January</option>
          <option value="02">February</option>
          <option value="03" >March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12" >December</option>
        </label>
      </select>
      <label>Day<input class="birthday" maxlength="2" name="BirthDay"  placeholder="Day" required=""></label>
      <label>Year <input class="birthyear" maxlength="4" name="BirthYear" placeholder="Year" required=""></label>
      </fieldset>
      <select class="select-style gender" name="gender">
        <option value="select">i am..</option>
        <option value="m">Male</option>
        <option value="f">Female</option>
        <option value="others">Other</option>
      </select><br><br>
      <p class="contact"><label for="phone">Mobile phone</label></p>
      <input id="phone" name="phone" placeholder="phone number" required="" type="text"> <br>
      <input class="buttom" name="submit" id="submit" tabindex="5" value="Sign me up!" type="submit">
  </form>
</div>
