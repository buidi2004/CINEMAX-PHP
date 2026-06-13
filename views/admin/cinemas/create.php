<div class="mb-4">
    <h2>ThĂªm Ráº¡p chiáº¿u má»›i</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/admin/cinemas">Ráº¡p chiáº¿u</a></li>
            <li class="breadcrumb-item active">ThĂªm má»›i</li>
        </ol>
    </nav>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/admin/cinemas/create">
            <?= csrf_field() ?>
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">TĂªn ráº¡p <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required 
                               placeholder="VD: CinemaX Nguyá»…n Huá»‡">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tá»‰nh/ThĂ nh phá»‘ <span class="text-danger">*</span></label>
                        <input type="text" name="province" class="form-control" required 
                               placeholder="VD: TP. Há»“ ChĂ­ Minh">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quáº­n/Huyá»‡n <span class="text-danger">*</span></label>
                        <input type="text" name="district" class="form-control" required 
                               placeholder="VD: Quáº­n 1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Äá»‹a chá»‰ chi tiáº¿t <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="2" required 
                                  placeholder="VD: 66 Nguyá»…n Huá»‡, Báº¿n NghĂ©"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sá»‘ Ä‘iá»‡n thoáº¡i</label>
                        <input type="tel" name="phone" class="form-control" 
                               placeholder="VD: 028-3824-5678">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="VD: cinema@example.com">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">VÄ© Ä‘á»™ (Latitude)</label>
                            <input type="number" name="latitude" class="form-control" step="0.00000001" 
                                   placeholder="VD: 10.7756790">
                            <small class="text-muted">Äá»ƒ láº¥y tá»« Google Maps</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kinh Ä‘á»™ (Longitude)</label>
                            <input type="number" name="longitude" class="form-control" step="0.00000001" 
                                   placeholder="VD: 106.7019270">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL áº¢nh ráº¡p</label>
                        <input type="text" name="image_url" class="form-control" 
                               value="/assets/images/cinemas/default.jpg">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá» má»Ÿ cá»­a</label>
                        <input type="text" name="opening_hours" class="form-control" 
                               value="08:00 - 23:00" placeholder="VD: 08:00 - 23:00">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">MĂ´ táº£</label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="MĂ´ táº£ vá» ráº¡p chiáº¿u..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiá»‡n Ă­ch (cĂ¡ch nhau bá»Ÿi dáº¥u pháº©y)</label>
                        <input type="text" name="facilities" class="form-control" 
                               placeholder="VD: IMAX,4DX,Dolby Atmos,Parking,F&B">
                        <small class="text-muted">
                            Gá»£i Ă½: IMAX, 4DX, Dolby Atmos, ScreenX, Sweetbox, VIP Lounge, Parking, F&B, Kids Zone
                        </small>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between">
                <a href="/admin/cinemas" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay láº¡i
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Táº¡o ráº¡p chiáº¿u
                </button>
            </div>
        </form>
    </div>
</div>
