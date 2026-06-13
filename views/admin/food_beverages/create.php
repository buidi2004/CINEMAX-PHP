<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/food-beverages" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label text-light">Tên Combo <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control bg-black text-light border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Mô tả chi tiết</label>
                        <textarea name="description" class="form-control bg-black text-light border-secondary" rows="3" placeholder="VD: 1 Bắp ngọt lớn + 2 Nước ngọt lớn"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control bg-black text-light border-secondary" required min="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-black border-secondary mb-3">
                        <div class="card-header border-secondary">
                            <h5 class="card-title mb-0 text-light">Tùy chọn</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                <label class="form-check-label text-light" for="isActive">Mở bán ngay</label>
                            </div>
                            <hr class="border-secondary">
                            <div class="mb-3">
                                <label class="form-label text-light">Hình ảnh Combo</label>
                                <input class="form-control bg-dark text-light border-secondary" type="file" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="card-footer border-secondary text-end">
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu Combo</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
