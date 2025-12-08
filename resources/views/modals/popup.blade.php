<style>
    .custom-popup {
  position: fixed;
  top: 20px;
  right: 20px;
  min-width: 300px;
  padding: 15px 20px;
  border-radius: 12px;
  color: #fff;
  font-weight: 500;
  font-family: "Inter", sans-serif;
  opacity: 0;
  transform: translateY(-20px);
  transition: all 0.4s ease;
  z-index: 9999;
}

.custom-popup.show {
  opacity: 1;
  transform: translateY(0);
}

.popup-content {
  display: flex;
  align-items: center;
  gap: 10px;
}

.popup-icon {
  font-size: 22px;
}

.custom-popup.success { background-color: #4caf50; }  /* Green */
.custom-popup.error { background-color: #f44336; }    /* Red */
.custom-popup.warning { background-color: #ff9800; }  /* Orange */
.custom-popup.info { background-color: #2196f3; }     /* Blue */

.custom-popup.show {
  opacity: 1;
  transform: translateY(0);
  animation: bounceIn 0.5s ease;
}

@keyframes bounceIn {
  0% { transform: scale(0.8); opacity: 0; }
  60% { transform: scale(1.05); opacity: 1; }
  100% { transform: scale(1); }
}

</style>
<div id="customPopup" class="custom-popup hidden">
  <div class="popup-content">
    <div class="popup-icon" id="popupIcon"></div>
    <p id="popupMessage"></p>
  </div>
</div>

<script>
    window.showPopup = function (type, message) {
  const popup = document.getElementById('customPopup');
  const msg = document.getElementById('popupMessage');
  const icon = document.getElementById('popupIcon');

  msg.textContent = message;

  // Icons (you can replace with font-awesome or Lucide)
  const icons = {
    success: '✅',
    error: '❌',
    warning: '⚠️',
    info: 'ℹ️'
  };

  icon.textContent = icons[type] || '';

  popup.className = `custom-popup ${type}`;
  popup.classList.add('show');

  setTimeout(() => {
    popup.classList.remove('show');
  }, 3000);
};

</script>
