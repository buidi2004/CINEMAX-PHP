<div class="mb-4">
    <h2>Sá»­a Ráº¡p chiáº¿u</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/admin/cinemas">Ráº¡p chiáº¿u</a></li>
            <li class="breadcrumb-item active">Sá»­a: <?= htmlspecialchars($cinema->name) ?></li>
        </ol>
    </nav>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/admin/cinemas/<?= $cinema->id ?>/edit">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">TĂªn ráº¡p <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required 
                               value="<?= htmlspecialchars($cinema->name) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tá»‰nh/ThĂ nh phá»‘ <span class="text-danger">*</span></label>
                        <input type="text" name="province" class="form-control" required 
                               value="<?= htmlspecialchars($cinema->province) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quáº­n/Huyá»‡n <span class="text-danger">*</span></label>
                        <input type="text" name="district" class="form-control" required 
                               value="<?= htmlspecialchars($cinema->district) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Äá»‹a chá»‰ chi tiáº¿t <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="2" required><?= htmlspecialchars($cinema->address) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sá»‘ Ä‘iá»‡n thoáº¡i</label>
                        <input type="tel" name="phone" class="form-control" 
                               value="<?= htmlspecialchars($cinema->phone ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= htmlspecialchars($cinema->email ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" 
                                   id="is_active" <?= $cinema->is_active ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Ráº¡p Ä‘ang hoáº¡t Ä‘á»™ng
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">VÄ© Ä‘á»™ (Latitude)</label>
                            <input type="number" name="latitude" class="form-control" step="0.00000001" 
                                   value="<?= $cinema->latitude ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kinh Ä‘á»™ (Longitude)</label>
                            <input type="number" name="longitude" class="form-control" step="0.00000001" 
                                   value="<?= $cinema->longitude ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL áº¢nh ráº¡p</label>
                        <input type="text" name="image_url" class="form-control" 
                               value="<?= htmlspecialchars($cinema->image_url) ?>">
                        <?php if ($cinema->image_url): ?>
                            <img src="<?= htmlspecialchars($cinema->image_url) ?>" 
                                 alt="Preview" class="img-thumbnail mt-2" style="max-height: 100px;">
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá» má»Ÿ cá»­a</label>
                        <input type="text" name="opening_hours" class="form-control" 
                               value="<?= htmlspecialchars($cinema->opening_hours) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">MĂ´ táº£</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($cinema->description ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiá»‡n Ă­ch (cĂ¡ch nhau bá»Ÿi dáº¥u pháº©y)</label>
                        <input type="text" name="facilities" class="form-control" 
                               value="<?= htmlspecialchars(implode(',', $cinema->facilities ?? [])) ?>">
                        <small class="text-muted">
                            Gá»£i Ă½: IMAX, 4DX, Dolby Atmos, ScreenX, Sweetbox, VIP Lounge, Parking, F&B
                        </small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <a href="/admin/cinemas" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay láº¡i
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Cáº­p nháº­t
                </button>
            </div>
        </form>
    </div>
</div>
