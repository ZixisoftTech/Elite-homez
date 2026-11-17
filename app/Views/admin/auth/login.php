<?php
use App\Helpers\Csrf;
use App\Helpers\Format;
use App\Helpers\Session;

$config = require dirname(__DIR__, 3) . '/Config/config.php';
$baseUrl = $config['base_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Login | Elite Homez Command Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/admin.css">
    <link rel="icon" type="image/png" href="<?= $baseUrl ?>/assets/images/logo.png">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--admin-navy-dark);
            padding: 1.5rem;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #FFFFFF;
            border-radius: 4px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background-color: var(--admin-navy);
            padding: 2.5rem 2rem;
            text-align: center;
            border-bottom: 3px solid var(--admin-gold);
        }
        .login-body {
            padding: 2.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            color: var(--admin-text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .form-control {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--admin-border);
            border-radius: 3px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--admin-gold);
            box-shadow: 0 0 0 3px rgba(183, 154, 60, 0.15);
        }
        .btn-login {
            width: 100%;
            padding: 0.95rem;
            background-color: var(--admin-navy);
            color: #FFFFFF;
            border: none;
            border-radius: 3px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: var(--admin-gold);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Elite Homez" height="46" style="background: #FFFFFF; padding: 4px 10px; border-radius: 2px;">
            <div style="font-size: 0.8rem; color: #CBD5E1; text-transform: uppercase; letter-spacing: 0.12em; margin-top: 1rem;">
                Executive Command Center
            </div>
        </div>

        <div class="login-body">
            <?php if (Session::hasFlash('error')): ?>
                <div style="background-color: #FEE2E2; border: 1px solid #F87171; color: #991B1B; padding: 0.75rem 1rem; border-radius: 3px; font-size: 0.85rem; margin-bottom: 1.5rem;">
                    <?= Format::e(Session::getFlash('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (Session::hasFlash('success')): ?>
                <div style="background-color: #DCFCE7; border: 1px solid #4ADE80; color: #166534; padding: 0.75rem 1rem; border-radius: 3px; font-size: 0.85rem; margin-bottom: 1.5rem;">
                    <?= Format::e(Session::getFlash('success')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/admin/login" method="POST">
                <?= Csrf::field() ?>

                <div class="form-group">
                    <label class="form-label" for="email">Administrator Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="admin@elitehomez.com" required autocomplete="username" autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••••••" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn-login">
                    Sign In Securely
                </button>
            </form>
        </div>
    </div>
</body>
</html>
