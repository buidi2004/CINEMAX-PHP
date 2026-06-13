<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/news" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="card bg-dark border-secondary">
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label text-light">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control bg-black text-light border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Tóm tắt</label>
                        <textarea name="summary" class="form-control bg-black text-light border-secondary" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Nội dung chi tiết</label>
                        <textarea name="content" class="form-control bg-black text-light border-secondary" rows="15"></textarea>
                        <small class="text-muted">Hỗ trợ mã HTML cơ bản.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-black border-secondary mb-3">
                        <div class="card-header border-secondary">
                            <h5 class="card-title mb-0 text-light">Tùy chọn</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_published" id="isPublished" checked>
                                <label class="form-check-label text-light" for="isPublished">Xuất bản ngay</label>
                            </div>
                            <hr class="border-secondary">
                            <div class="mb-3">
                                <label class="form-label text-light">Ảnh đại diện (Thumbnail)</label>
                                <input class="form-control bg-dark text-light border-secondary" type="file" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="card-footer border-secondary text-end">
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu bài viết</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
