<!DOCTYPE html>
<html lang="en">
<head>
    <title>Masuk - LogiStock</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary: hsl(221, 83%, 53%);
            --background: hsl(222, 47%, 11%);
            --foreground: hsl(213, 31%, 91%);
            --card: hsl(222, 47%, 13%);
            --border: hsl(217, 32%, 17%);
            --input: hsl(217, 32%, 17%);
            --radius: 0.75rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--foreground);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        /* =========================
           LOADING SCREEN
        ========================= */

        #loading-screen {
            position: fixed;
            inset: 0;
            background-color: var(--background);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 9999;

            opacity: 1;
            visibility: visible;

            transition:
                opacity 0.5s ease,
                visibility 0.5s ease;
        }

        #loading-screen.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loading-logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;

            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;

            margin-bottom: 1.5rem;

            animation: logoAppear 0.8s ease;
        }

        .loading-icon {
            width: 38px;
            height: 38px;

            animation: iconPulse 1.2s infinite;
        }

        .loading-spinner {
            width: 38px;
            height: 38px;

            border: 4px solid var(--border);
            border-top-color: var(--primary);

            border-radius: 50%;

            animation: spin 1s linear infinite;

            margin-bottom: 1rem;
        }

        .loading-text {
            font-size: 0.9rem;
            opacity: 0.7;

            animation: textFade 1.2s infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes logoAppear {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes iconPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes textFade {
            0% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.4;
            }
        }

        /* =========================
           LOGIN CARD
        ========================= */

        .card {
            background-color: var(--card);

            border: 1px solid var(--border);

            border-radius: var(--radius);

            padding: 2.5rem;

            width: 100%;
            max-width: 400px;

            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .logo {
            color: var(--primary);

            display: flex;
            align-items: center;

            gap: 0.75rem;

            font-weight: 700;
            font-size: 1.5rem;

            margin-bottom: 2rem;

            justify-content: center;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;

            font-size: 0.875rem;

            font-weight: 500;

            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;

            padding: 0.75rem 1rem;

            background-color: var(--input);

            border: 1px solid var(--border);

            border-radius: var(--radius);

            color: var(--foreground);

            font-size: 1rem;

            outline: none;

            transition: border 0.2s;
        }

        input:focus {
            border-color: var(--primary);
        }

        .btn {
            width: 100%;

            padding: 0.75rem;

            background-color: var(--primary);

            color: white;

            border: none;

            border-radius: var(--radius);

            font-weight: 600;

            cursor: pointer;

            transition: opacity 0.2s;

            margin-top: 1rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error {
            color: #f87171;

            background: rgba(248, 113, 113, 0.1);

            padding: 0.75rem;

            border-radius: var(--radius);

            font-size: 0.875rem;

            margin-bottom: 1rem;

            border: 1px solid rgba(248, 113, 113, 0.2);
        }

        p {
            text-align: center;

            margin-top: 1.5rem;

            font-size: 0.875rem;
        }

        a {
            color: var(--primary);

            text-decoration: none;

            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- =========================
         LOADING SCREEN
    ========================= -->

    <div id="loading-screen">

        <div class="loading-logo">

            <i
                data-lucide="package"
                class="loading-icon">
            </i>

            <span>LogiStock</span>

        </div>

        <div class="loading-spinner"></div>

        <div class="loading-text">
            Memuat sistem gudang...
        </div>

    </div>


    <!-- =========================
         LOGIN CARD
    ========================= -->

    <div class="card">

        <div class="logo">

            <i data-lucide="package"></i>

            <span>
                LogiStock - close: perbaikan fitur
            </span>

        </div>


        <h2 style="text-align: center; margin-bottom: 2rem;">
            Masuk ke akun Anda
        </h2>


        <?php if (isset($error)): ?>

            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST" action="index.php">

            <div class="form-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    required
                    autofocus
                    placeholder="username">

            </div>


            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••">

            </div>


            <button
                type="submit"
                class="btn">

                Masuk Sekarang

            </button>

        </form>


        <p>
            Belum punya akun?

            <a href="views/auth/register.php">
                Sign Up
            </a>
        </p>

    </div>


    <!-- =========================
         JAVASCRIPT
    ========================= -->

    <script>

        // Aktifkan icon Lucide
        lucide.createIcons();


        // Jalankan loading screen
        window.addEventListener('load', function () {

            setTimeout(function () {

                const loadingScreen =
                    document.getElementById('loading-screen');

                loadingScreen.classList.add('hide');

            }, 1500);

        });

    </script>

</body>
</html>