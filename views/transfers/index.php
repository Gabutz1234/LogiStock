<div class="header-actions">
    <div>
        <h1>Inter-Warehouse Transfers</h1>
        <p class="subtitle">Track and manage stock movements between facilities</p>
    </div>
    <a href="/transfers/create" class="btn btn-primary">
        <i data-lucide="plus"></i> New Transfer
    </a>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Origin Warehouse</th>
                <th>Destination Warehouse</th>
                <th>Fleet</th>
                <th>Status</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shipments as $s): ?>
            <tr>
                <td style="color:hsl(215, 20%, 65%)">#<?= $s['id'] ?></td>
                <td style="font-weight: 500; font-size: 0.8125rem;"><?= htmlspecialchars($s['origin_name']) ?></td>
                <td style="font-weight: 500; font-size: 0.8125rem;"><?= htmlspecialchars($s['destination_name']) ?></td>
                <td><span class="badge badge-info"><?= htmlspecialchars($s['fleet_name']) ?></span></td>
                <td>
                    <?php if ($s['status'] === 'DRAFT'): ?>
                        <span class="badge" style="background:var(--border); color:var(--foreground);">DRAFT</span>
                    <?php elseif ($s['status'] === 'ON_DELIVERY'): ?>
                        <span class="badge badge-warning">ON DELIVERY</span>
                    <?php else: ?>
                        <span class="badge badge-success">RECEIVED</span>
                    <?php endif; ?>
                </td>
                <td style="text-align:right">
                    <form action="/transfers/<?= $s['id'] ?>/status" method="POST" style="display:inline;">
                        <?php if ($s['status'] === 'DRAFT'): ?>
                            <input type="hidden" name="status" value="ON_DELIVERY">
                            <button type="submit" class="btn" style="background:var(--primary); color:white; padding: 0.4rem 0.8rem;">
                                Start Delivery
                            </button>
                        <?php elseif ($s['status'] === 'ON_DELIVERY'): ?>
                            <input type="hidden" name="status" value="RECEIVED">
                            <button type="submit" class="btn" style="background:var(--success); color:white; padding: 0.4rem 0.8rem;">
                                Order Received
                            </button>
                        <?php else: ?>
                            <button class="btn" disabled style="opacity: 0.5;">Completed</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($shipments)): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding: 3rem; color:hsl(215, 20%, 65%);">
                    No active transfers found. Start a new one to move stock.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
