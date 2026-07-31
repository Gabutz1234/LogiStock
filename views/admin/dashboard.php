<div class="header-actions">
    <div>
        <h1>Dashboard</h1>
        <p class="subtitle">Real-time inventory overview across all warehouses</p>
    </div>
</div>

<div class="grid">
    <div class="card">
        <h3 style="font-size: 0.875rem; color: hsl(215, 20%, 65%);">Total Items</h3>
        <p style="font-size: 2rem; font-weight: 700; margin-top: 0.5rem;"><?= count($overview) ?></p>
    </div>
    <!-- More stats cards could go here -->
</div>

<div class="card table-container" style="margin-top: 2rem;">
    <div style="padding: 0 0 1.5rem 0;">
        <h3 style="font-size: 1.125rem;">Inventory Status</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Warehouse</th>
                <th>Current Stock</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($overview as $row): ?>
            <tr>
                <td><code><?= htmlspecialchars($row['item_code']) ?></code></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($row['item_name']) ?></td>
                <td><?= htmlspecialchars($row['warehouse_name']) ?></td>
                <td>
                    <span class="<?= $row['quantity'] <= 5 ? 'badge-warning' : 'badge-success' ?>" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <?= number_format($row['quantity']) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($row['unit']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($overview)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 3rem; color: hsl(215, 20%, 65%);">
                    No inventory records found. Add some stock to get started.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
