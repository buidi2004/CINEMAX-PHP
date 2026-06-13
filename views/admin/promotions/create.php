<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/promotions" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label text-light">Mã Khuyến Mãi (CODE) <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control bg-black text-warning fw-bold border-secondary text-uppercase" placeholder="VD: SUMMER2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Tiêu đề (Tên chương trình)</label>
                        <input type="text" name="title" class="form-control bg-black text-light border-secondary" placeholder="VD: Khuyến mãi giải nhiệt mùa hè">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Mô tả</label>
                        <textarea name="description" class="form-control bg-black text-light border-secondary" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Loại giảm giá <span class="text-danger">*</span></label>
                            <select name="discount_type" class="form-select bg-black text-light border-secondary">
                                <option value="percent">Theo phần trăm (%)</option>
                                <option value="fixed">Số tiền cố định (VNĐ)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Mức giảm <span class="text-danger">*</span></label>
                            <input type="number" name="discount_value" class="form-control bg-black text-light border-secondary" required min="1" step="0.01">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-black border-secondary mb-3">
                        <div class="card-header border-secondary">
                            <h5 class="card-title mb-0 text-light">Điều kiện & Tùy chọn</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                                <label class="form-check-label text-light" for="isActive">Kích hoạt ngay</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light">Số lượng giới hạn</label>
                                <input type="number" name="max_uses" class="form-control bg-dark text-light border-secondary" placeholder="Để trống nếu vô hạn">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light">Hạn sử dụng</label>
                                <input type="datetime-local" name="expires_at" class="form-control bg-dark text-light border-secondary">
                            </div>
                            <hr class="border-secondary">
                            <div class="mb-3">
                                <label class="form-label text-light">Ảnh Banner (Tùy chọn)</label>
                                <input class="form-control bg-dark text-light border-secondary" type="file" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="card-footer border-secondary text-end">
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu Khuyến Mãi</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
