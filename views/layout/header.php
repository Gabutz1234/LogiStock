<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Inventaris' ?> - LogiStock</title>
    <!-- Modern Typeface -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: hsl(221, 83%, 53%);
            --primary-foreground: hsl(210, 40%, 98%);
            --background: hsl(222, 47%, 11%);
            --foreground: hsl(213, 31%, 91%);
            --card: hsl(222, 47%, 13%);
            --card-foreground: hsl(213, 31%, 91%);
            --border: hsl(217, 32%, 17%);
            --input: hsl(217, 32%, 17%);
            --ring: hsl(224, 76%, 48%);
            --radius: 0.75rem;
            --success: hsl(142, 70%, 45%);
            --destructive: hsl(0, 84%, 60%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--background); color: var(--foreground); min-height: 100vh; display: grid; grid-template-columns: 280px 1fr; }
        aside { background-color: var(--card); border-right: 1px solid var(--border); padding: 2rem 1.5rem; display: flex; flex-direction: column; gap: 2rem; position: sticky; top: 0; height: 100vh; overflow: auto;}
        .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        nav { display: flex; flex-direction: column; gap: 0.5rem; flex-grow: 1; }
        nav a { padding: 0.75rem 1rem; color: var(--foreground); text-decoration: none; border-radius: var(--radius); font-weight: 500; display: flex; align-items: center; gap: 0.75rem; transition: all 0.2s ease; opacity: 0.7; }
        nav a:hover { background-color: var(--border); opacity: 1; }
        nav a.active { background-color: var(--primary); color: var(--primary-foreground); opacity: 1; }
        .user-info { border-top: 1px solid var(--border); padding-top: 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .logout-btn { color: var(--destructive); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        main { padding: 2.5rem; max-width: 1400px; margin: 0 auto; width: 100%; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        h1 { font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; }
        .subtitle { color: hsl(215, 20%, 65%); font-size: 0.875rem; }
        .card { background-color: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
        .btn { padding: 0.625rem 1.25rem; border-radius: var(--radius); font-weight: 500; cursor: pointer; transition: background 0.2s; border: none; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 0.875rem; }
        .btn-primary { background-color: var(--primary); color: var(--primary-foreground); }
        .btn-destructive { background-color: var(--destructive); color: white; }
        .table-container { width: 100%; overflow-x: auto; margin-top: 1.5rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: hsl(215, 20%, 65%); border-bottom: 1px solid var(--border); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); font-size: 0.875rem; }
        .badge { padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-success { background: hsla(142, 70%, 45%, 0.1); color: var(--success); }
        .badge-warning { background: hsla(38, 92%, 50%, 0.1); color: hsl(38, 92%, 50%); }
        .badge-info { background: hsla(221, 83%, 53%, 0.1); color: var(--primary); }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
        input, select, textarea { width: 100%; padding: 0.625rem 0.875rem; background-color: var(--input); border: 1px solid var(--border); border-radius: var(--radius); color: var(--foreground); font-size: 0.875rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; }
        .alert { padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem; }
        .alert-error { background: hsla(0, 84%, 60%, 0.1); color: var(--destructive); border: 1px solid var(--destructive); }
    </style>
</head>
<body>
    <?php 
        $currentFile = basename($_SERVER['PHP_SELF']);
        $isAdmin = $_SESSION['role'] === 'admin';
    ?>
    <aside>
        <a href="dashboard.php" class="logo">
            <i data-lucide="package"></i>
            <span>LogiStock</span>
        </a>

        <nav>
            <a href="dashboard.php" class="<?= $currentFile === 'dashboard.php' ? 'active' : '' ?>">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            <?php if ($isAdmin): ?>
                <a href="warehouses.php" class="<?= $currentFile === 'warehouses.php' ? 'active' : '' ?>">
                    <i data-lucide="warehouse"></i> Gudang
                </a>
                <a href="items.php" class="<?= $currentFile === 'items.php' ? 'active' : '' ?>">
                    <i data-lucide="box"></i> Katalog Barang
                </a>
                <a href="fleets.php" class="<?= $currentFile === 'fleets.php' ? 'active' : '' ?>">
                    <i data-lucide="truck"></i> Armada
                </a>
            <?php endif; ?>

            <a href="stock.php" class="<?= $currentFile === 'stock.php' ? 'active' : '' ?>">
                <i data-lucide="list"></i> Data Stok
            </a>
            <a href="inventory.php?action=in" class="<?= $currentFile === 'inventory.php' && ($_GET['action'] ?? '') === 'in' ? 'active' : '' ?>">
                <i data-lucide="arrow-down-left"></i> Stok Masuk
            </a>
            <a href="inventory.php?action=out" class="<?= $currentFile === 'inventory.php' && ($_GET['action'] ?? '') === 'out' ? 'active' : '' ?>">
                <i data-lucide="arrow-up-right"></i> Stok Keluar
            </a>
            <a href="transfers.php" class="<?= $currentFile === 'transfers.php' || $currentFile === 'transfers_create.php' ? 'active' : '' ?>">
                <i data-lucide="arrow-left-right"></i> Mutasi Stok
            </a>
            <a href="reports.php" class="<?= $currentFile === 'reports.php' ? 'active' : '' ?>">
                <i data-lucide="history"></i> Riwayat Stok
            </a>
        </nav>

        <div class="user-info">
            <div>
                <p style="font-size: 0.875rem; font-weight: 600;"><?= htmlspecialchars($_SESSION['username'] ?? 'Pengguna') ?></p>
                <p class="subtitle" style="text-transform: capitalize;"><?= $_SESSION['role'] === 'admin' ? 'Administrator' : 'Staf' ?></p>
            </div>
            <a href="logout.php" class="logout-btn">
                <i data-lucide="log-out">Logout</i>
            </a>
        </div>
    </aside>

    <main>
