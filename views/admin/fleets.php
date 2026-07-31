<div class="header-actions">
    <div>
        <h1>Fleets</h1>
        <p class="subtitle">Manage delivery vehicles and shipping resources</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('add-modal').toggleAttribute('hidden')">
        <i data-lucide="plus"></i> Add Fleet
    </button>
</div>

<div id="add-modal" class="card" style="margin-bottom: 2rem;" hidden>
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
        <h3 style="font-size: 1.25rem;">New Fleet</h3>
        <button onclick="document.getElementById('add-modal').toggleAttribute('hidden')" style="background:none; border:none; color:inherit; cursor:pointer;">&times;</button>
    </div>
    <form action="/admin/fleets" method="POST">
        <div class="grid">
            <div class="form-group">
                <label for="name">Fleet Name</label>
                <input type="text" id="name" name="name" required placeholder="Main Center Truck A">
            </div>
            <div class="form-group">
                <label for="type">Vehicle Type</label>
                <select id="type" name="type" required>
                    <option value="Truck">Truck</option>
                    <option value="Van">Van</option>
                    <option value="Trailer">Trailer</option>
                    <option value="Motorcycle">Motorcycle</option>
                </select>
            </div>
            <div class="form-group">
                <label for="license_plate">License Plate</label>
                <input type="text" id="license_plate" name="license_plate" placeholder="ABC-1234">
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">Save Fleet</button>
        </div>
    </form>
</div>

<div class="card table-container">
    <table>
        <thead>
            <tr>
                <th>Fleet ID</th>
                <th>Name / Description</th>
                <th>Type</th>
                <th>License Plate</th>
                <th style="text-align:right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fleets as $f): ?>
            <tr>
                <td style="color:hsl(215, 20%, 65%)">#<?= $f['id'] ?></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($f['name']) ?></td>
                <td><span class="badge badge-info"><?= $f['type'] ?></span></td>
                <td><code><?= htmlspecialchars($f['license_plate'] ?: 'N/A') ?></code></td>
                <td style="text-align:right">
                    <button class="btn" style="background:var(--border); padding: 0.5rem;"><i data-lucide="truck" style="width:1rem;"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
