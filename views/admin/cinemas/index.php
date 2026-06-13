<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quáº£n lĂ½ Ráº¡p chiáº¿u</h2>
    <a href="/admin/cinemas/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> ThĂªm Ráº¡p má»›i
    </a>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tá»‰nh/ThĂ nh phá»‘</label>
                <select name="province" class="form-select">
                    <option value="">-- Táº¥t cáº£ --</option>
                    <?php foreach ($provinces as $prov): ?>
                        <option value="<?= htmlspecialchars($prov) ?>" 
                            <?= $selectedProvince === $prov ? 'selected' : '' ?>>
                            <?= htmlspecialchars($prov) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> Lá»c
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Cinemas List -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TĂªn ráº¡p</th>
                        <th>Tá»‰nh/TP</th>
                        <th>Äá»‹a chá»‰</th>
                        <th>Sá»‘ phĂ²ng</th>
                        <th>Tráº¡ng thĂ¡i</th>
                        <th>HĂ nh Ä‘á»™ng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cinemas)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                KhĂ´ng cĂ³ ráº¡p chiáº¿u nĂ o
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($cinemas as $cinema): ?>
                            <tr>
                                <td><?= $cinema->id ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($cinema->name) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($cinema->slug) ?></small>
                                </td>
                                <td><?= htmlspecialchars($cinema->province) ?></td>
                                <td>
                                    <small><?= htmlspecialchars($cinema->address) ?></small>
                                </td>
                                <td>
                                    <a href="/admin/cinemas/<?= $cinema->id ?>/rooms" class="btn btn-sm btn-info">
                                        Xem phĂ²ng
                                    </a>
                                </td>
                                <td>
                                    <?php if ($cinema->is_active): ?>
                                        <span class="badge bg-success">Hoáº¡t Ä‘á»™ng</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Táº¡m dá»«ng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="/admin/cinemas/<?= $cinema->id ?>/edit" 
                                           class="btn btn-warning" title="Sá»­a">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/admin/cinemas/<?= $cinema->id ?>/delete" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Báº¡n cĂ³ cháº¯c muá»‘n xĂ³a ráº¡p nĂ y?')"
                                           title="XĂ³a">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
