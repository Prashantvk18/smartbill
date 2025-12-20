<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'SmartBill' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #13263fff, #202b43ff, #2c5364);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        /* ===== CARD ===== */
        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 25px 22px;
            border-radius: 14px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        }

        .auth-title {
            text-align: center;
            color: #3c7facff;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .auth-subtitle {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 14px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #36658bff;
            box-shadow: 0 0 0 1px rgba(44,83,100,0.25);
        }

        /* ===== BUTTON ===== */
        .btn-primary {
            width: 100%;
            background: #224e81ff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: #224e81ff;
        }

        /* ===== ERROR ===== */
        .error-box {
            background: #ffe5e5;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .error-box ul {
            padding-left: 18px;
        }

        /* ===== FOOTER LINKS ===== */
        .auth-footer {
            text-align: center;
            font-size: 13px;
            margin-top: 15px;
        }

        .auth-footer a {
            color: #43a2caff;
            text-decoration: none;
            font-weight: 600;
        }

        /* ===== MOBILE OPTIMIZATION ===== */
        @media (max-width: 480px) {
            body {
                min-height: 10vh;
            }
            .auth-card {
                padding: 22px 18px;
            }

            .auth-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="auth-card">
