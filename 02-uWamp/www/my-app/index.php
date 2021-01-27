<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/styles.css">
        <link rel="stylesheet" href="./css/select.css">
        <title>Page Title</title>
    </head>
    <body>

        <div class="login-page">

            <div class="form">
                <form class="register-form">
                    <input type="text" placeholder="name"/>
                    <input type="password" placeholder="password"/>
                    <input type="text" placeholder="email address"/>
                    <button>create</button>
                    <p class="message">Already registered? <a href="#">Sign In</a></p>
                </form>

                <form class="login-form">
                    <div class="select">
                    <select name="slct" id="slct">
                        <option value="1">Lausanne</option>
                        <option value="2">Morges</option>
                        <option value="3">Nyon</option>
                    </select>
                    </div>
                    <input type="password" placeholder="password"/>
                    <button>login</button>
                    <p class="message">Not registered? <a href="#">Create an account</a></p>
                </form>
            </div>
        </div>
        

    </body>
</html>