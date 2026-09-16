document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert-success');

    alerts.forEach(function (alert) {
        // Tự thêm class Bootstrap, không cần sửa Blade
        alert.classList.add('fade', 'show');

        // Sau 3 giây bắt đầu fade
        setTimeout(function () {
            alert.classList.remove('show');

            // Đợi hiệu ứng fade hoàn thành rồi ẩn
            setTimeout(function () {
                alert.style.display = 'none';
            }, 200);
        }, 3000);
    });
});