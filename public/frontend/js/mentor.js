
function selectTask(card) {

  // Highlight task đang chọn 
  document.querySelectorAll('.kcard').forEach(c => {
    c.style.borderColor = '';
  });
  card.style.borderColor = 'var(--c-primary)';

  // Lấy dữ liệu từ card
  const task = {
    id: card.dataset.id || '',
    title: card.dataset.title || '',
    description: card.dataset.description || '',
    intern: card.dataset.intern || '',
    deadline: card.dataset.deadline || '',
    priority: card.dataset.priority || 'medium',
    status: card.dataset.status || '',
    comment: card.dataset.comment || ''
  };

  // Panel
  const panel = document.getElementById('reviewPanel');
  const form = document.getElementById('reviewTaskForm');

  // Tiêu đề panel
  document.getElementById('reviewTaskTitle').textContent = task.title;

  // Hidden id
  document.getElementById('reviewTaskId').value = task.id;

  // Thông tin readonly
  document.getElementById('reviewTaskIntern').value = task.intern;
  document.getElementById('reviewTaskStatus').value = task.status;

  // Các field chỉnh sửa
  document.getElementById('reviewTaskDeadline').value = task.deadline;
  document.getElementById('reviewTaskPriority').value = task.priority;
  document.getElementById('reviewTaskTitleInput').value = task.title;
  document.getElementById('reviewTaskDescription').value = task.description;
  document.getElementById('reviewTaskComment').value = task.comment;

  // Đổi action của form
  if (form && task.id && form.dataset.baseAction) {
    form.action = form.dataset.baseAction.replace('__ID__', task.id);
  }

  // Logic nút action
  const isReview = task.status === 'Review';

  const btnDoing = document.getElementById('btnReturnDoing');
  const btnDone = document.getElementById('btnConfirmDone');

  if (btnDoing) {
    btnDoing.disabled = !isReview;
    btnDoing.classList.toggle('active-action', isReview);
  }

  if (btnDone) {
    btnDone.disabled = !isReview;
    btnDone.classList.toggle('active-action', isReview);
  }

  // Scroll xuống panel
  if (panel) {
    panel.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
  }
}

/**
 * Tasks page: Giao task mới 
 */
function openCreateTaskModal() {
  const modal = document.getElementById('createTaskModal');
  if (modal) modal.classList.add('open');
}
function closeCreateTaskModal() {
  const modal = document.getElementById('createTaskModal');
  if (modal) modal.classList.remove('open');
}


function viewInternDetail(internId) {
  window.location.href = '/mentor/interns/' + internId;
}

document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.getElementById('createTaskModal');
  if (overlay) {
    overlay.addEventListener('click', function (event) {
      if (event.target === overlay) closeCreateTaskModal();
    });
  }
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') closeCreateTaskModal();
  });
});


(function () {
  const _base = window.selectTask;

  window.selectTask = function (card) {
    if (typeof _base === 'function') _base(card); // gọi lại hàm gốc

    const isReview = (card.dataset.status || '') === 'Review';
    const btnDoing = document.getElementById('btnReturnDoing');
    const btnDone = document.getElementById('btnConfirmDone');

    if (btnDoing) btnDoing.classList.toggle('active-action', isReview);
    if (btnDone) btnDone.classList.toggle('active-action', isReview);
  };
})();