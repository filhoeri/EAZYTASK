<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Aplikasi E-Learning</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <h1>Login</h1>
      <div class="login-form">
        <input type="text" id="username" placeholder="Username" required />
        <br />
        <br />
        <input type="password" id="password" placeholder="Password" required />
        <br />
        <button
          id="loginBtn"
          style="padding: 20px; margin-top: 20px; margin-left: 200px"
        >
          Login
        </button>
        <p id="error" style="color: red"></p>
      </div>
    </div>

    <script src="script_login.js"></script>
  </body>
</html>
