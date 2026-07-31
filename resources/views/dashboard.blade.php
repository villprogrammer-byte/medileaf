<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MediLeaf</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f8faf9;
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dash-card {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(20, 78, 40, 0.08);
        }

        .dash-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle, #f4fcf5 5%, #e8f7eb 100%);
            color: #159447;
            font-size: 34px;
        }

        .dash-card h2 {
            font-weight: 800;
            color: #09252e;
            margin-bottom: 6px;
        }

        .dash-card p {
            color: #687982;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .logout-btn {
            width: 100%;
            min-height: 50px;
            border: 0;
            border-radius: 9px;
            background: linear-gradient(90deg, #2cc052 0%, #0d9840 100%);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
        }

        .logout-btn:hover {
            opacity: 0.92;
        }
    </style>
</head>

<body>

    <div class="dash-card">

        <div class="dash-icon">
            <i class="bi bi-person-check-fill"></i>
        </div>

        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>You are successfully logged in to your MediLeaf account.</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</body>

</html>