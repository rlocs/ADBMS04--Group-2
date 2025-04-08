<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barangay Healthcare System</title>
    </head> 
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 10px;
        }

        .logo {
            margin-right: 80px;
        }

        .logo img {
            max-width: 400px;
            height:auto;
        }

        .login_box {
            background-color: #e0e0e0;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        .login_box p {
        margin: 10px 0 5px;
        }

        .login_box input,
        .login_box select,
        .login_box button {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login_box button {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
        }

        .login_box button:hover {
            background-color: blue;
        }
    </style>
    <body>
        <div class="container">
            <div class="logo">
                <img src=" https://i.pinimg.com/236x/ab/3d/e2/ab3de2f5cc08f507f728f39c66e596b8.jpg" 
                alt="Barangay Health Center Logo">
            </div>
            <div class="login_box">
                <form action="" method="POST">
                    <p>E-mail Address:</p>
                    <input type="text" name="entered_email" maxlength="35" required>
                    <p>Password:</p>
                    <input type="password" name="entered_password" maxlength="16" required>
                    <p>Select Role:</p>
                    <select name="Role">
                        <option value="Healthworker">Health Worker</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Nurse">Nurse</option>
                    </select>
                    <button type="submit" name="log_in">Log In</button>
                </form>
            </div>
        </div>
    </body>
</html>
