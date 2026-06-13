<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="/admin/contacts" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card bg-dark border-secondary mb-4">
            <div class="card-header border-secondary">
                <h5 class="card-title mb-0 text-light">Thông tin liên hệ</h5>
            </div>
            <div class="card-body">
                <table class="table table-dark table-borderless">
                    <tbody>
                        <tr>
                            <td style="width: 150px" class="text-muted">Người gửi:</td>
                            <td><strong><?= htmlspecialchars($contact->name) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email:</td>
                            <td><a href="mailto:<?= htmlspecialchars($contact->email) ?>" class="text-info"><?= htmlspecialchars($contact->email) ?></a></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Ngày gửi:</td>
                            <td><?= date('d/m/Y H:i', strtotime($contact->created_at)) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Chủ đề:</td>
                            <td><strong><?= htmlspecialchars($contact->subject) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <hr class="border-secondary">
                <h6 class="text-muted mb-3">Nội dung tin nhắn:</h6>
                <div class="p-3 bg-black border border-secondary rounded text-light" style="white-space: pre-wrap;"><?= htmlspecialchars($contact->message) ?></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card bg-dark border-secondary">
            <div class="card-header border-secondary">
                <h5 class="card-title mb-0 text-light">Xử lý yêu cầu</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-light">Trạng thái</label>
                        <select name="status" class="form-select bg-black text-light border-secondary">
                            <option value="pending" <?= $contact->status === 'pending' ? 'selected' : '' ?>>Đang chờ xử lý</option>
                            <option value="resolved" <?= $contact->status === 'resolved' ? 'selected' : '' ?>>Đã xử lý</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Ghi chú / Nội dung phản hồi</label>
                        <textarea name="reply_message" class="form-control bg-black text-light border-secondary" rows="5" placeholder="Nhập ghi chú xử lý nội bộ..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Cập nhật trạng thái</button>
                </form>
            </div>
        </div>
    </div>
</div>
