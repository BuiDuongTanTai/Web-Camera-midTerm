<?php
// Lấy thông tin giỏ hàng
$cart = getCartDetails();
?>
<!-- Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (empty($cart['items'])): ?>
                <div class="text-center py-5">
                    <i class="bi bi-cart text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-3">Giỏ hàng của bạn đang trống</p>
                    <button class="btn btn-outline-primary mt-3" data-bs-dismiss="modal">Tiếp tục mua sắm</button>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col" class="text-end">Giá</th>
                                <th scope="col" class="text-center">Số lượng</th>
                                <th scope="col" class="text-end">Tổng</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="cart-thumbnail me-3" style="background-image: url('<?php echo htmlspecialchars($item['image']); ?>');"></div>
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                        <button class="btn btn-outline-secondary update-cart" data-product-id="<?php echo $item['id']; ?>" data-action="decrease"><i class="bi bi-dash"></i></button>
                                        <input type="text" class="form-control text-center" value="<?php echo $item['quantity']; ?>" readonly>
                                        <button class="btn btn-outline-secondary update-cart" data-product-id="<?php echo $item['id']; ?>" data-action="increase"><i class="bi bi-plus"></i></button>
                                    </div>
                                </td>
                                <td class="text-end"><?php echo number_format($item['total'], 0, ',', '.'); ?>đ</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger remove-from-cart" data-product-id="<?php echo $item['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                    </button>
                    <div class="text-end">
                        <h5>Tổng cộng: <span class="text-danger"><?php echo number_format($cart['total'], 0, ',', '.'); ?>đ</span></h5>
                        <small class="text-muted">Đã bao gồm VAT</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($cart['items'])): ?>
            <div class="modal-footer">
                <button class="btn btn-outline-danger clear-cart">Xóa giỏ hàng</button>
                <a href="<?php echo SITE_URL; ?>/pages/checkout.php" class="btn btn-primary">Thanh toán</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>