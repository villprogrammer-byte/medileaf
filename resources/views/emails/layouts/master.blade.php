<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <style>
        /* Sari email CSS yahan rahegi */
        body {
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            font-family: Arial, Helvetica, sans-serif;
        }

        .body-wrapper {
            width: 100%;
            background: #f7f7f7;
            padding: 20px 0;
        }

        .mail-wrapper {
            width: 700px;
            max-width: 100%;
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
            text-align: center;
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

        @media only screen and (max-width: 600px) {
            .mail-wrapper {
                width: 100% !important;
                border-radius: 0 !important;
            }

            .mail-body {
                padding: 15px !important;
            }

            .label {
                width: 40% !important;
            }
        }
    </style>

</head>

<body>

    <table class="body-wrapper" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td>
                @yield('content')
            </td>
        </tr>
    </table>

</body>

</html>