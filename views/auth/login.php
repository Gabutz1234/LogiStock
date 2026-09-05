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
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--background); color: var(--foreground); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1.5rem; }
        .card { background-color: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 2.5rem; width: 100%; max-width: 400px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); }
        .logo { color: var(--primary); display: flex; align-items: center; gap: 0.75rem; font-weight: 700; font-size: 1.5rem; margin-bottom: 2rem; justify-content: center; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.75rem 1rem; background-color: var(--input); border: 1px solid var(--border); border-radius: var(--radius); color: var(--foreground); font-size: 1rem; }
        .btn { width: 100%; padding: 0.75rem; background-color: var(--primary); color: white; border: none; border-radius: var(--radius); font-weight: 600; cursor: pointer; transition: opacity 0.2s; margin-top: 1rem; }
        .error { color: #f87171; background: rgba(248, 113, 113, 0.1); padding: 0.75rem; border-radius: var(--radius); font-size: 0.875rem; margin-bottom: 1rem; border: 1px solid rgba(248, 113, 113, 0.2); }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <i data-lucide="package"></i>
            <span>LogiStock - perbaikan fitur</span>
        </div>
        <h2 style="text-align: center; margin-bottom: 2rem;">Masuk ke akun Anda</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus placeholder="username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">Masuk Sekarang</button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
