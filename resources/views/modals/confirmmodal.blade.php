<style>
.custom-modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 99999; /* modal container always on top */
}

.hidden {
  display: none !important;
}

.modal-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(3px);
  z-index: 1; /* behind the modal box */
}

.modal-box {
  position: relative;
  z-index: 2; /* ensure it’s above blur */
  background: #1e1e2f;
  color: #fff;
  border-radius: 12px;
  padding: 25px 30px;
  max-width: 400px;
  width: 90%;
  text-align: center;
  box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
  animation: popupFadeIn 0.35s ease;
}

.modal-box h3 {
  margin-bottom: 10px;
  font-size: 1.3rem;
}

.modal-box p {
  margin-bottom: 20px;
  color: #ccc;
}

.modal-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.btn-cancel, .btn-confirm {
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: 0.25s ease;
}

.btn-cancel {
  background: #444;
  color: #ddd;
}

.btn-cancel:hover {
  background: #666;
}

.btn-confirm {
  background: #9f4bff;
  color: #fff;
  box-shadow: 0 0 12px rgba(159, 75, 255, 0.4);
}

.btn-confirm:hover {
  background: #7b2cd4;
}

@keyframes popupFadeIn {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

</style>
<div id="confirmModal" class="custom-modal hidden">
  <div class="modal-backdrop"></div>
  <div class="modal-box">
    <h3 id="modalTitle">Confirm Action</h3>
    <p id="modalMessage">Are you sure you want to continue?</p>
    <div class="modal-actions">
      <button id="modalCancel" class="btn-cancel">Cancel</button>
      <button id="modalConfirm" class="btn-confirm">Yes</button>
    </div>
  </div>
</div>

<script>
    window.showConfirm = function (title, message, callback) {
  const modal = document.getElementById('confirmModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalMessage = document.getElementById('modalMessage');
  const confirmBtn = document.getElementById('modalConfirm');
  const cancelBtn = document.getElementById('modalCancel');

  modalTitle.textContent = title;
  modalMessage.textContent = message;

  modal.classList.remove('hidden');

  // Event bindings
  const cleanup = () => {
    modal.classList.add('hidden');
    confirmBtn.removeEventListener('click', onConfirm);
    cancelBtn.removeEventListener('click', onCancel);
  };

  const onConfirm = () => { cleanup(); callback(true); };
  const onCancel = () => { cleanup(); callback(false); };

  confirmBtn.addEventListener('click', onConfirm);
  cancelBtn.addEventListener('click', onCancel);
};

</script>
