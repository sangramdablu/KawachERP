<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    @include('modals.confirmmodal')
    @include('modals.successmodal')
    @include('modals.editstudent')

<body>
  {{-- <div class="row" id="proBanner">
    <div class="col-12">
      <span class="d-flex align-items-center purchase-popup">
        <p>Get tons of UI components, Plugins, multiple layouts, 20+ sample pages, and more!</p>
        <a href="https://bootstrapdash.com/demo/polluxui/template/index.html?utm_source=organic&utm_medium=banner&utm_campaign=free-preview" target="_blank" class="btn download-button purchase-button ml-auto">Upgrade To Pro</a>
        <i class="typcn typcn-delete-outline" id="bannerClose"></i>
      </span>
    </div>
  </div> --}}
  <div class="container-scroller">

    @include('layouts.navbar')
    
    <div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
        @include('layouts.rightsidebar')
    <!-- partial -->

    <!-- partial:partials/_sidebar.html -->
        @include('layouts.sidebar')
    <!-- partial -->

      <div class="main-panel">

    <!-- content-wrapper ends -->
        @yield('content')
    <!-- content-wrapper ends -->

    <!-- partial:partials/_footer.html -->
        @yield('layouts.footer')
    <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- container-scroller -->
        @include('layouts.jsfiles')
  <!-- End custom js for this page-->
</body>

</html>

