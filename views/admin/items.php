<div class="header-actions">
    <div>
        <h1>Items Catalog</h1>
        <p class="subtitle">Maintain product details and storage requirements</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('add-modal').toggleAttribute('hidden')">
        <i data-lucide="plus"></i> Add New Item
    </button>
</div>

<div id="add-modal" class="card" style="margin-bottom: 2rem;" hidden>
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
        <h3 style="font-size: 1.25rem;">New Item</h3>
        <button onclick="document.getElementById('add-modal').toggleAttribute('hidden')" style="background:none; border:none; color:inherit; cursor:pointer;">&times;</button>
    </div>
    <form action="/admin/items" method="POST">
        <div class="grid">
            <div class="form-group">
                <label for="code">SKU Code</label>
                <input type="text" id="code" name="code" required placeholder="SKU-001">
            </div>
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" required placeholder="Premium Coffee Beans">
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <select id="unit" name="unit" required>
                    <option value="Box">Box</option>
                    <option value="Kg">Kg</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Pallet">Pallet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="storage_temp">Storage Temperature</label>
                <input type="text" id="storage_temp" name="storage_temp" placeholder="Room Temp / -20°C">
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">Save Item</button>
        </div>
    </form>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th>SKU Code</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Storage</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i): ?>
            <tr>
                <td><code><?= htmlspecialchars($i['code']) ?></code></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($i['name']) ?></td>
                <td><span class="badge badge-info"><?= $i['unit'] ?></span></td>
                <td><?= htmlspecialchars($i['storage_temp'] ?: 'N/A') ?></td>
                <td style="text-align:right">
                    <button class="btn" style="background:var(--border); padding: 0.5rem;"><i data-lucide="edit-3" style="width:1rem;"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
