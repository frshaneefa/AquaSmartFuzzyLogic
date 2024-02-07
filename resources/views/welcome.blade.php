<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AquaSmart</title>
    <link rel="icon" href="/aqua.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #e0f7fa;
            color: #37474f;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1; /* Set z-index to -1 to place it behind other elements */
        }

        .navbar {
            background-color: #004d40;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 40px;
            height: auto;
            margin-right: 10px;
        }

        .brand-name {
            color: #ffffff;
            font-size: 1.5rem;
        }

        .navbar-right {
            display: flex;
        }

        .navbar a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 1rem;
            font-size: 1rem;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .login-button {
            margin-top: 1rem;
            background-color: #004d40;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }

        .center-container {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 50vh;
            width: 100%;
        }

        h1 {
            color: white;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .center-text {
            text-align: center;
            color: white;
            margin-top: 1rem;
            font-size: 1.2rem;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .card {
            width: 18rem;
            margin: 1rem;
            box-sizing: border-box;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }

        .card-body {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            max-height: 150px;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover .card-body {
            transform: translateY(0);
        }

        .card-title {
            color: #00796b;
        }

        .card-text {
            color: #37474f;
            margin-bottom: 0;
        }

        .more-link {
            color: #00796b;
            cursor: pointer;
            text-decoration: none;
        }

        .hidden-text {
            display: none;
        }

        .visible {
            display: block;
        }

        footer {
            background-color: #004d40;
            color: #ffffff;
            text-align: center;
            padding: 1rem;
        }

        .center-text,
        h1,
        .card {
            opacity: 0;
            transform: translateY(20px); /* Initial position, adjust as needed */
            animation: fadeInSlideIn 1s ease-in-out forwards;
        }

        @keyframes fadeInSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px); /* Start with opacity 0 and translateY 20px */
            }
            to {
                opacity: 1;
                transform: translateY(0); /* End with opacity 1 and translateY 0 */
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: center;
                margin-bottom: 0.5rem;
            }

            .card-container {
                margin-top: 1rem; /* Adjust the margin for spacing on mobile */
            }

            .navbar-right {
                margin-top: 1rem;
            }

            .navbar a {
                margin: 0.5rem 0;
            }

            .card {
                width: 100%;
                margin: 0.5rem 0;
            }

            .card img {
                border-radius: 0.5rem 0.5rem 0 0;
            }
        }
    </style>
</head>
<body class="antialiased">
    <video id="background-video" autoplay muted loop>
        <source src="vidback.mp4" type="video/mp4">
    </video>
    <div class="navbar">
        <div class="navbar-left">
            <img src="logoa.png" alt="AquaSmart Logo" class="logo">
            <span class="brand-name">AquaSmart</span>
        </div>
        <div class="navbar-right">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="{{ url('/dashboard') }}" class="login-button">Dashboard</a>
                        <a href="{{ url('/analytics') }}">Analytics</a>
                        @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
    <div class="center-container">
        <h1>A Q U A . S M A R T </h1>
        <p class="center-text">Introducing the Smart Water Pump Control System for homes</p>
        <p class="center-text">a futuristic solution using advanced fuzzy logic. Here's how it benefits you:</p>

        <div class="card-container">
            <div class="card">
                <img src="ob1.jpg" class="card-img-top" alt="Objective 1 Image">
                <div class="card-body">
                    <h5 class="card-title">Efficient Water Management:</h5>
                    <p class="card-text">To study the requirement for efficient residential water pump control and management using IoT.</p>
                </div>
            </div>

            <div class="card">
                <img src="ob2.jpg" class="card-img-top" alt="Objective 2 Image">
                <div class="card-body">
                    <h5 class="card-title">Enhanced Pump Performance:</h5>
                    <p class="card-text">To develop an IoT system for residential water pump control and monitoring using fuzzy logic.</p>
                </div>
            </div>

            <div class="card">
                <img src="ob3.jpg" class="card-img-top" alt="Objective 3 Image">
                <div class="card-body">
                    <h5 class="card-title">Empowered Decision-Making:</h5>
                    <p class="card-text">To evaluate the efficacy of the IoT-based smart water pump control and monitoring system.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer style="background-color: #004d40; color: #ffffff; text-align: center; padding: 1rem;">
        &copy; 2024 AquaSmart. All rights reserved.
    </footer>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const elements = document.querySelectorAll('.center-text, h1, .card');

        elements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.5}s`;
        });
    });
</script>

