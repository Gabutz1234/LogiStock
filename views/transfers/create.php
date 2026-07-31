<div class="header-actions">
    <div>
        <h1>New Transfer Request</h1>
        <p class="subtitle">Select items and quantities to move between warehouses</p>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="card" style="background:hsla(0, 84%, 60%, 0.1); color:hsl(0, 84%, 60%); margin-bottom: 2rem;">
        <?= $error ?>
    </div>
<?php endif; ?>

<form action="/transfers/store" method="POST">
    <div class="grid" style="grid-template-columns: 1fr 1fr 1fr; margin-bottom: 2.5rem;">
        <div class="form-group">
            <label for="origin_warehouse_id">Origin Warehouse</label>
            <select id="origin_warehouse_id" name="origin_warehouse_id" required>
                <option value="">Select Origin</option>
                <?php foreach ($warehouses as $w): ?>
                    <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="destination_warehouse_id">Destination Warehouse</label>
            <select id="destination_warehouse_id" name="destination_warehouse_id" required>
                <option value="">Select Destination</option>
                <?php foreach ($warehouses as $w): ?>
                    <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fleet_id">Shipping Fleet</label>
            <select id="fleet_id" name="fleet_id" required>
                <option value="">Select Fleet</option>
                <?php foreach ($fleets as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['name']) ?> (<?= $f['type'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="card" style="margin-bottom: 2.5rem;">
        <h3 style="font-size: 1.125rem; margin-bottom: 1.5rem;">Select Items & Quantities</h3>
        <div id="item-list">
            <?php foreach ($items as $index => $i): ?>
            <div class="grid" style="grid-template-columns: 2fr 1fr; align-items: flex-end; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom:0">
                    <label>Item #<?= $index + 1 ?></label>
                    <input type="hidden" name="item_ids[]" value="<?= $i['id'] ?>">
                    <input type="text" value="<?= htmlspecialchars($i['name']) ?> (<?= $i['code'] ?>)" disabled style="opacity: 0.7;">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label>Quantity to Transfer</label>
                    <input type="number" name="quantities[]" min="0" placeholder="0">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div style="display:flex; justify-content:flex-end; gap: 1rem;">
        <a href="/transfers" class="btn" style="background:var(--border);">Cancel</a>
        <button type="submit" class="btn btn-primary">Create Transfer (DRAFT)</button>
    </div>
</form>
