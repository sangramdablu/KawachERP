<style>
/* === Base Modal Styles (Same as Confirm Modal) === */
.custom-modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 99999;
}

.hidden {
  display: none !important;
}

.modal-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(3px);
}

.modal-box {
  position: relative;
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

/* === Button === */
.btn-close {
  border: none;
  padding: 10px 25px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  background: linear-gradient(45deg, #00c853, #69f0ae);
  color: #1a1a1a;
  box-shadow: 0 5px 15px rgba(0, 200, 83, 0.5);
  transition: all 0.3s ease-in-out;
}

.btn-close:hover {
  background: linear-gradient(45deg, #00b04c, #4df39c);
  transform: translateY(-2px);
  box-shadow: 0 7px 20px rgba(0, 200, 83, 0.7);
}

/* === Popup Animations === */
@keyframes popupFadeIn {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

/* === SUCCESS ICON CIRCLE === */
.success-circle {
  height: 100px;
  width: 100px;
  border-radius: 50%;
  margin: 10px auto 20px auto;
  background: #00e676;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 50px;
  box-shadow: 0 0 25px rgba(0, 230, 118, 0.6);
  animation: circlePop 0.6s ease-out forwards, pulseGlow 2s infinite ease-in-out;
  transform: scale(0);
}

/* === Circle Pop Animation === */
@keyframes circlePop {
  0% { transform: scale(0); opacity: 0; }
  70% { transform: scale(1.15); opacity: 1; }
  100% { transform: scale(1); opacity: 1; }
}

/* === Glow Pulse Animation === */
@keyframes pulseGlow {
  0% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0.5); }
  70% { box-shadow: 0 0 0 20px rgba(0, 230, 118, 0); }
  100% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0); }
}

</style>

<!-- === SUCCESS MODAL HTML === -->
<div id="successModal" class="custom-modal hidden">
  <div class="modal-backdrop"></div>
  <div class="modal-box">
    <div id="successCircle" class="success-circle">✔</div>
    <h3 id="successModalTitle">Success!</h3>
    <p id="successModalMessage">Your action was completed successfully.</p>
    <div class="modal-actions">
      <button id="modalClose" class="btn-close">Close</button>
    </div>
  </div>
</div>

<script>
window.showSuccess = function (title, message, callback) {
  const modal = document.getElementById('successModal');
  const modalTitle = document.getElementById('successModalTitle');
  const modalMessage = document.getElementById('successModalMessage');
  const successCircle = document.getElementById('successCircle');
  const closeBtn = document.getElementById('modalClose');

  // Set title and message
  modalTitle.textContent = title;
  modalMessage.textContent = message;

  // Show modal
  modal.classList.remove('hidden');

  // Trigger pop animation
  successCircle.style.animation = 'circlePop 0.6s ease-out forwards, pulseGlow 2s infinite ease-in-out';

  // Cleanup function
  const cleanup = () => {
    modal.classList.add('hidden');
    successCircle.style.animation = ''; // reset animation
    closeBtn.removeEventListener('click', onClose);
  };

  const onClose = () => { cleanup(); if (callback) callback(); };
  closeBtn.addEventListener('click', onClose);
};
</script>
