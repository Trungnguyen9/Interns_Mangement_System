/* ==========================================================================
   IMS – Intern Portal Scripts
   public/js/intern.js
   ========================================================================== */
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


// 
async function showTaskDetail(id) {
  const res = await fetch(`/internpage/tasks/edit/${id}`);
  const html = await res.text();

  document.getElementById('task-detail-content').innerHTML = html;
  document.getElementById('task-detail-modal').classList.remove('hidden');
}

function closeTaskDetail() {
  document.getElementById('task-detail-modal').classList.add('hidden');
}

// Gắn MỘT LẦN duy nhất trên phần tử cha cố định — không phải trên #task-update-form
document.getElementById('task-detail-modal').addEventListener('submit', async function (e) {
  const form = e.target.closest('#task-update-form');
  if (!form) return; // sự kiện submit không phải từ form update task thì bỏ qua

  e.preventDefault(); // chặn hành vi mặc định là load lại cả trang

  const formData = new FormData(form);
  const taskId = formData.get('task_id');

  const res = await fetch(form.action, {
    method: 'POST', // POST thật, nhưng có @method('PUT') trong formData để Laravel hiểu là PUT
    body: formData,
    headers: { 'Accept': 'application/json' },
  });

  const data = await res.json();

  if (data.success) {
    // Cập nhật badge ngay trong bảng danh sách, không cần load lại trang
    const rowBadge = document.getElementById(`status-badge-${taskId}`);
    if (rowBadge) {
      rowBadge.textContent = data.status;
      rowBadge.className = `badge ${data.status}`;

    }

    closeTaskDetail();
  } else {
    alert(data.message);
  }
});