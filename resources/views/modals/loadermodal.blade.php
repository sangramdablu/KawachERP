<style>
/* -------- Loader Animation (Your Provided Code) -------- */
/* -------- Loader Animation (Original Animation, Center-Safe) -------- */
.loader {
  width: 20px;
  aspect-ratio: 1;
  background: #25b09b;
  box-shadow: 0 0 60px 15px #25b09b;
  clip-path: inset(0);
  animation:
    l4-1 0.5s ease-in-out infinite alternate,
    l4-2 1s ease-in-out infinite;
  margin: 0 auto; /* CENTER the loader */
}

@keyframes l4-1 {
  100% { transform: translateX(80px); }
}
@keyframes l4-2 {
  33% { clip-path: inset(0 0 0 -100px); }
  50% { clip-path: inset(0 0 0 0); }
  83% { clip-path: inset(0 -100px 0 0); }
}

/* -------- Modal Container -------- */
.loader-modal {
  position: fixed;
  inset: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;   /* CENTER VERTICALLY */
  align-items: center;       /* CENTER HORIZONTALLY */
  z-index: 999999;
}

.hidden { display: none !important; }

/* -------- Backdrop -------- */
.loader-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  z-index: 1;
}

/* -------- Loader Box (Centered Content) -------- */
.loader-box {
  position: relative;
  z-index: 2;
  background: #1e1e2f;
  padding: 35px 40px;
  border-radius: 14px;
  
  width: 90%;
  max-width: 380px;
  
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;   /* CENTER everything inside */

  text-align: center;
  color: white;
  box-shadow: 0 0 25px rgba(0,0,0,0.4);
  animation: fadeInScale 0.35s ease;
}

@keyframes fadeInScale {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

#loaderMessage {
  margin-top: 18px;
  font-size: 1rem;
  color: #ddd;
  min-height: 25px;
}

/* RESPONSIVE FIX */
@media (max-width: 450px) {
  .loader-box {
    padding: 25px 20px;
  }
}


</style>

<div id="globalLoaderModal" class="loader-modal hidden">
    
    <div class="loader-backdrop"></div>

    <div class="loader-box">
        <div class="loader"></div>
        <div id="loaderMessage">Loading...</div>
    </div>

</div>

<script>
let messageIndex = 0;
let messageInterval = null;

/**
 * Show Loader Globally
 * @param messages array of messages to rotate (optional)
 */
window.showLoader = function(messages = ["Loading..."]) {
    
    const modal = document.getElementById("globalLoaderModal");
    const messageBox = document.getElementById("loaderMessage");

    clearInterval(messageInterval);
    messageIndex = 0;
    messageBox.textContent = messages[0];
    modal.classList.remove("hidden");

    if (messages.length > 1) {
        messageInterval = setInterval(() => {
            messageIndex = (messageIndex + 1) % messages.length;
            messageBox.textContent = messages[messageIndex];
        }, 3000);
    }
};

/**
 * Hide Loader Modal
 */
window.hideLoader = function() {
    clearInterval(messageInterval);
    document.getElementById("globalLoaderModal").classList.add("hidden");
};
</script>
