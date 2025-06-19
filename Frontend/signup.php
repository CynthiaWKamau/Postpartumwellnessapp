<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup-Wellness Application</title>

    </head>
    <body>
        <div class="signup-box">
            <h2>Choose your role</h2>
<form action="" method="post" autocomplete="off">
    <select name="role" required>
        <option value="">--Select Role--</option>
        <option value="mother">Postpartum Mother</option>
        <option value="therapist">Therapist</option>
        <option value="admin">Admin</option>
    </select>
    <br>
    <button type="submit" name="submit">Next</button>
</form>
        </div>   
      <div class="container">
        <h2>Sign Up</h2>
        <form action="" method="post" autocomplete="off">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
            
            <button type="submit" name="submit">Sign Up</button>
        </form>  

    </div> 
 </body>  
</html>