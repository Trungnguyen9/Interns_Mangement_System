/* ==========================================================================
   IMS – Intern Portal Scripts
   public/js/intern.js
   ========================================================================== */

/**
 * ----- Tasks page: task detail modal -----
 * Usage in Blade: onclick="openDetail(this)" trên nút "Xem" của mỗi dòng task,
 * truyền data-* attribute nếu cần render động (đã chừa sẵn data binding mẫu bên dưới).
 */
function openDetail(trigger) {
  const modal = document.getElementById('taskModal');
  if (!modal) return;

  // Nếu nút "Xem" có data-attributes, có thể bind dữ liệu động vào modal ở đây.
  // Ví dụ (bỏ comment khi cần):
  // if (trigger) {
  //   document.getElementById('modalTaskTitle').textContent = trigger.dataset.title;
  //   document.getElementById('modalTaskDesc').textContent  = trigger.dataset.description;
  // }

  modal.classList.add('open');
}

function closeDetail() {
  const modal = document.getElementById('taskModal');
  if (modal) modal.classList.remove('open');
}

/**
 * ----- Weekly Report page: toggle the "submit new report" form -----
 */
function toggleForm() {
  const form = document.getElementById('submitForm');
  if (!form) return;

  form.classList.toggle('open');
  if (form.classList.contains('open')) {
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

/**
 * ----- Global: close modal when clicking outside of it -----
 * Gắn listener tập trung tại đây thay vì inline onclick trong Blade,
 * giúp tách hẳn JS ra khỏi markup.
 */
document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.getElementById('taskModal');
  if (overlay) {
    overlay.addEventListener('click', function (event) {
      if (event.target === overlay) closeDetail();
    });
  }

  // Đóng modal bằng phím Esc
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') closeDetail();
  });
});
