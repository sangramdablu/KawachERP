<div id="sideModal" class="sidebar-modal">
    <div class="sideModalsidebar-resizer"></div>

    <div class="sidebar-content">
        <div class="sidebar-header">
            <h4 id="modalTitle">Modal Title</h4>
            <button class="close-sidebar" onclick="closeSidebar()">✕</button>
        </div>

        <div id="modalBody" class="sidebar-body">
            <!-- Dynamic content loads here -->
        </div>
    </div>
</div>

<div id="sidebarOverlay" class="sidebar-overlay"></div>


<script>
    // Close sidebar when clicking on overlay
    $(document).on('click', '#sidebarOverlay', function(e) {
        if (e.target === this) {
            closeSidebar();
        }
    });

    const sidesidebar = document.getElementById("sideModal");
    const sideresizer = document.querySelector(".sideModalsidebar-resizer");

    let siderisResizing = false;

    sideresizer.addEventListener("mousedown", function(e){
        siderisResizing = true;
        document.body.style.userSelect = "none";
    });

    document.addEventListener("mousemove", function(e){
        if(!siderisResizing) return;

        let newWidth = window.innerWidth - e.clientX;
        if(newWidth < 450) newWidth = 450;
        if(newWidth > 1200) newWidth = 1200;

        sidesidebar.style.width = newWidth + "px";
    });

    document.addEventListener("mouseup", function(){
        siderisResizing = false;
        document.body.style.userSelect = "auto";
    });

    sideresizer.addEventListener("mousedown", function(){
        siderisResizing = true;
        document.body.classList.add("resizing");
    });

    document.addEventListener("mouseup", function(){
        siderisResizing = false;
        document.body.classList.remove("resizing");
    });

</script>