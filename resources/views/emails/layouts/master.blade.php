<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>
        /* Sari email CSS yahan rahegi */
        body {
            margin: 0;
            padding: 20px;
            background: #f7f7f7;
            font-family: Arial, Helvetica, sans-serif;
        }

        .mail-wrapper {
            width: 700px;
            margin: auto;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
        }

        .mail-header {
            background: #2f7d32;
            color: #fff;
            padding: 20px;
        }

        .mail-header h2 {
            margin: 0;
        }

        .mail-body {
            padding: 25px;
        }

        .mail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .mail-table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .label {
            width: 35%;
            font-weight: bold;
            background: #fafafa;
        }

        .submitted-date {
            margin-top: 20px;
        }

        .mail-footer {
            background: #f5f5f5;
            padding: 15px;
            font-size: 13px;
            color: #666;
            text-align: center;
        }
    </style>

</head>

<body>

    @yield('content')

</body>

</html>