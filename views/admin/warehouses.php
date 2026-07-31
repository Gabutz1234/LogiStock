<div class="header-actions">
    <div>
        <h1>Warehouses</h1>
        <p class="subtitle">Manage storage locations and facility details</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('add-modal').toggleAttribute('hidden')">
        <i data-lucide="plus"></i> Add Warehouse
    </button>
</div>

<div id="add-modal" class="card" style="margin-bottom: 2rem;" hidden>
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
        <h3 style="font-size: 1.25rem;">New Warehouse</h3>
        <button onclick="document.getElementById('add-modal').toggleAttribute('hidden')" style="background:none; border:none; color:inherit; cursor:pointer;">&times;</button>
    </div>
    <form action="/admin/warehouses" method="POST">
        <div class="grid">
            <div class="form-group">
                <label for="name">Warehouse Name</label>
                <input type="text" id="name" name="name" required placeholder="Main Distribution Center">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required placeholder="New York, NY">
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">Save Warehouse</button>
        </div>
    </form>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Created At</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($warehouses as $w): ?>
            <tr>
                <td style="color:hsl(215, 20%, 65%)">#<?= $w['id'] ?></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($w['name']) ?></td>
                <td><?= htmlspecialchars($w['location']) ?></td>
                <td><?= date('M d, Y', strtotime($w['created_at'])) ?></td>
                <td style="text-align:right">
                    <button class="btn" style="background:var(--border); padding: 0.5rem;"><i data-lucide="more-horizontal" style="width:1rem;"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
