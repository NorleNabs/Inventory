<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Form - Bootstrap</title>
    <link rel="icon" href="anong-context-nung-nakadila-si-alden-v0-q630lpmhcj0f1.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        body {
            background: url('desk-3139127_1920.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }


        .login-card {
            background-color: rgba(255, 255, 255, 0.31);
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: none;
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding-bottom: 0;
        }

        .social-login .btn {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-login .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 1rem;
            color: #6c757d;
        }

        .login-btn {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border: none;
            transition: all 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 117, 252, 0.4);
        }

        .form-floating>label {
            color: #6c757d;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        .text-gradient {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card login-card p-4">
                    <div class="card-header text-center pb-0">
                        <h2 class="fw-bold mb-1">Welcome to InventoyPro</h2>
                        <p class="text-muted mb-4">Please sign in to continue</p>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="POST" action="log_in_handler.php">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Your username" required>
                                <label for="username">Username</label>
                                <div class="invalid-feedback">Please enter your username</div>
                            </div>


                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <label for="password">Password</label>
                                <div class="invalid-feedback">Password must be at least 6 characters</div>
                            </div>


                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-decoration-none text-gradient">Forgot Password?</a>
                            </div>


                            <button type="submit" class="btn btn-primary login-btn w-100 py-3 mb-3">Sign In</button>


                            <div class="text-center">
                                <p class="mb-0">Don't have an account? <a href="#"
                                        class="text-decoration-none text-gradient fw-semibold">Request for Account
                                        Here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.getElementById('login-form');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let isValid = true;

            // Username validation
            if (usernameInput.value.trim() === "") {
                usernameInput.classList.add('is-invalid');
                isValid = false;
            } else {
                usernameInput.classList.remove('is-invalid');
                usernameInput.classList.add('is-valid');
            }



            if (isValid) {
                form.submit(); // Now actually submit the form
            } else {
                const card = document.querySelector('.login-card');
                card.classList.add('shake');
                setTimeout(() => {
                    card.classList.remove('shake');
                }, 500);
            }
        });
    </script>
</body>

</html>