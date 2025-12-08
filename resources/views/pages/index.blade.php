@extends('layouts.master')

@section('content')
@php
    $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';
    // Fetch installed modules for the logged-in school
    $tenantModules = DB::connection($central)
        ->table('school_modules')
        ->join('modules', 'modules.id', '=', 'school_modules.module_id')
        ->where('school_modules.school_id', Session::get('tenant_id'))
        ->get();
@endphp

<style>
  /* Custom CSS for Catech.AI Landing Section */

/* Variables for easier theme management (optional but good practice) */
:root {
    --catech-ai-dark-bg: #6a0dad;
    --catech-ai-purple-light: #9f4bff;
    --catech-ai-purple-dark: #6a0dad;
    --catech-ai-white: #ffffff;
    --catech-ai-gray: #b0b0b0;
    --catech-ai-input-bg: #2a2a47;
    --catech-ai-border-color: #3f3f61;
}

.catech-ai-hero-section {
    background-image: url('{{ asset("images/output/robotbanner.png") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-color: var(--catech-ai-dark-bg); /* fallback */
    color: var(--catech-ai-white);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
    overflow: hidden;
    position: relative;
    margin: 0 30px 30px 30px;
    border-radius: 5px;
}

.catech-ai-hero-section::before {
    content: '';
    position: absolute;
    bottom: -10%;
    left: 0;
    width: 100%;
    height: 30%;
    background: radial-gradient(ellipse at center, rgba(106, 13, 173, 0.3) 0%, rgba(13, 13, 30, 0) 70%);
    filter: blur(80px);
    z-index: 0;
}


.catech-ai-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
    z-index: 1; /* Ensure content is above pseudo-elements */
    position: relative;
}

/* Navbar Styling */
.catech-ai-navbar {
    padding: 1rem 0;
    margin-bottom: 3rem;
    border-bottom: 1px solid var(--catech-ai-border-color); /* Subtle separator */
}

.catech-ai-brand {
    color: var(--catech-ai-white);
    font-weight: bold;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
}

.catech-ai-logo-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    background-color: var(--catech-ai-purple-light);
    border-radius: 50%;
    margin-right: 8px;
    box-shadow: 0 0 10px var(--catech-ai-purple-light);
}

.catech-ai-nav-links .nav-link {
    color: var(--catech-ai-gray);
    margin: 0 15px;
    transition: color 0.3s ease;
}

.catech-ai-nav-links .nav-link:hover,
.catech-ai-nav-links .nav-link.active {
    color: var(--catech-ai-white);
}

.catech-ai-btn-signup {
    background-color: transparent;
    border: 1px solid var(--catech-ai-border-color);
    color: var(--catech-ai-gray);
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    margin-right: 10px;
    transition: all 0.3s ease;
}

.catech-ai-btn-signup:hover {
    border-color: var(--catech-ai-purple-light);
    color: var(--catech-ai-white);
}

.catech-ai-btn-login {
    background-color: var(--catech-ai-purple-light);
    border: none;
    color: var(--catech-ai-white);
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(159, 75, 255, 0.4);
    transition: all 0.3s ease;
}

.catech-ai-btn-login:hover {
    background-color: var(--catech-ai-purple-dark);
    box-shadow: 0 0 20px rgba(106, 13, 173, 0.6);
}

/* Hero Content Styling */
.catech-ai-content-row {
    padding-top: 3rem;
    padding-bottom: 3rem;
}

.catech-ai-main-heading {
    font-size: 3.5rem;
    font-weight: bold;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    background: linear-gradient(to right, var(--catech-ai-white), var(--catech-ai-gray));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.catech-ai-description-text {
    font-size: 1.1rem;
    color: var(--catech-ai-gray);
    margin-bottom: 2rem;
    line-height: 1.6;
    max-width: 500px;
}

.catech-ai-subscribe-form {
    display: flex;
    margin-bottom: 1.5rem;
    max-width: 450px;
}

.catech-ai-email-input {
    background-color: var(--catech-ai-input-bg);
    border: 1px solid var(--catech-ai-border-color);
    color: var(--catech-ai-white);
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
    flex-grow: 1;
}

.catech-ai-email-input::placeholder {
    color: var(--catech-ai-gray);
    opacity: 0.7;
}

.catech-ai-email-input:focus {
    background-color: var(--catech-ai-input-bg);
    border-color: var(--catech-ai-purple-light);
    box-shadow: 0 0 0 0.25rem rgba(159, 75, 255, 0.25);
    color: var(--catech-ai-white);
}

.catech-ai-btn-getstarted {
    background-color: var(--catech-ai-purple-light);
    border: none;
    color: var(--catech-ai-white);
    padding: 0.8rem 2rem;
    border-radius: 8px;
    margin-left: 10px;
    font-weight: 500;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.catech-ai-btn-getstarted:hover {
    background-color: var(--catech-ai-purple-dark);
    box-shadow: 0 0 20px rgba(106, 13, 173, 0.6);
}

.catech-ai-small-text {
    font-size: 0.85rem;
    color: var(--catech-ai-gray);
    opacity: 0.8;
    max-width: 450px;
}

/* Image Column Styling */
.catech-ai-image-column {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px; /* Ensure space for the image */
}

/* Responsive Adjustments */
@media (max-width: 991.98px) {
    .catech-ai-navbar {
        border-bottom: none;
    }
    .catech-ai-nav-links {
        margin-top: 1rem;
    }
    .catech-ai-auth-buttons {
        margin-top: 1rem;
        flex-direction: column;
        align-items: flex-start;
    }
    .catech-ai-btn-signup {
        margin-bottom: 10px;
        margin-right: 0;
    }
    .catech-ai-text-column {
        text-align: center;
        margin-bottom: 3rem;
    }
    .catech-ai-main-heading {
        font-size: 2.8rem;
    }
    .catech-ai-description-text,
    .catech-ai-small-text {
        margin-left: auto;
        margin-right: auto;
    }
    .catech-ai-subscribe-form {
        flex-direction: column;
        max-width: 80%;
        margin-left: auto;
        margin-right: auto;
    }
    .catech-ai-email-input {
        margin-bottom: 10px;
        margin-right: 0 !important;
    }
    .catech-ai-btn-getstarted {
        width: 100%;
        margin-left: 0;
    }
    .catech-ai-image-column {
        min-height: 300px;
    }
}

@media (max-width: 575.98px) {
    .catech-ai-main-heading {
        font-size: 2rem;
    }
    .catech-ai-email-input,
    .catech-ai-btn-getstarted {
        padding: 0.7rem 1.2rem;
    }
}
</style>

@if($tenantModules->isEmpty())
<section class="catech-ai-hero-section">
    <div class="container-fluid catech-ai-container">
        <nav class="navbar navbar-expand-lg catech-ai-navbar">
            <a class="navbar-brand catech-ai-brand" target="_blank" href="{{ url('https://kawachtech.com/') }}">
                <span class="catech-ai-logo-dot"></span> kawachtech.com
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#catechAiNavbarContent" aria-controls="catechAiNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="catechAiNavbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 catech-ai-nav-links">
                    <li class="nav-item">
                        <a class="nav-link catech-ai-nav-link" target="_blank" href="{{ url('https://kawachtech.com/software-solution-services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link catech-ai-nav-link" target="_blank" href="{{ url('https://kawachtech.com/') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link catech-ai-nav-link" target="_blank" href="{{ url('https://kawachtech.com/kawach-technology-blogs') }}">Blogs</a>
                    </li>
                </ul>
                {{-- <div class="d-flex catech-ai-auth-buttons">
                    <button class="btn catech-ai-btn-signup" type="submit">Sign Up</button>
                    <button class="btn catech-ai-btn-login" type="submit">Login</button>
                </div> --}}
            </div>
        </nav>

        <div class="row align-items-center catech-ai-content-row">
            <div class="col-lg-6 catech-ai-text-column">
                <h1 class="catech-ai-main-heading">Kawach ERP Powerful AI Based Management System</h1>
                <p class="catech-ai-description-text">Kawach ERP is an intelligent, all-in-one school management
                   platform designed to simplify operations, enhance collaboration, and empower administrators, 
                   teachers, students, and parents through automation, insights, and seamless digital connectivity.
                  </p>
                {{-- <form class="d-flex catech-ai-subscribe-form"> --}}
                    {{-- <input class="form-control me-2 catech-ai-email-input" type="email" placeholder="Enter email" aria-label="Enter email"> --}}
                    <a href="{{ route('school.modules.index') }}"><button class="btn catech-ai-btn-getstarted" type="submit">Install Modules</button></a>
                {{-- </form> --}}
                <p class="catech-ai-small-text mt-1">Powered By Kawach Technology</p>
            </div>
            <div class="col-lg-6 d-flex justify-content-center catech-ai-image-column">
                {{-- <img src="{{ asset('images/output/robotimage.png') }}" alt="AI Robot" class="img-fluid catech-ai-robot-img"> --}}
            </div>
        </div>
    </div>
</section>
@else
  <div class="content-wrapper">

    <div class="row">
      <div class="col-xl-6 grid-margin stretch-card flex-column">
        <h5 class="mb-2 text-titlecase mb-4">Status statistics</h5>
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <p class="mb-0 text-muted">Transactions</p>
                  <p class="mb-0 text-muted">+1.37%</p>
                </div>
                <h4>1352</h4>
                <canvas id="transactions-chart" class="mt-auto" height="65"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div>
                    <p class="mb-2 text-muted">Sales</p>
                    <h6 class="mb-0">563</h6>
                  </div>
                  <div>
                    <p class="mb-2 text-muted">Orders</p>
                    <h6 class="mb-0">720</h6>
                  </div>
                  <div>
                    <p class="mb-2 text-muted">Revenue</p>
                    <h6 class="mb-0">5900</h6>
                  </div>
                </div>
                <canvas id="sales-chart-a" class="mt-auto" height="65"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="row h-100">
          <div class="col-md-6 stretch-card grid-margin grid-margin-md-0">
            <div class="card">
              <div class="card-body d-flex flex-column justify-content-between">
                <p class="text-muted">Sales Analytics</p>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h3 class="mb-">27632</h3>
                  <h3 class="mb-">78%</h3>
                </div>
                <canvas id="sales-chart-b" class="mt-auto" height="38"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="row h-100">
                  <div class="col-6 d-flex flex-column justify-content-between">
                    <p class="text-muted">CPU</p>
                    <h4>55%</h4>
                    <canvas id="cpu-chart" class="mt-auto"></canvas>
                  </div>
                  <div class="col-6 d-flex flex-column justify-content-between">
                    <p class="text-muted">Memory</p>
                    <h4>123,65</h4>
                    <canvas id="memory-chart" class="mt-auto"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 grid-margin stretch-card flex-column">
        <h5 class="mb-2 text-titlecase mb-4">Income statistics</h5>
        <div class="row h-100">
          <div class="col-md-12 stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                  <div>
                    <p class="mb-3">Monthly Increase</p>
                    <h3>67842</h3>
                  </div>
                  <div id="income-chart-legend" class="d-flex flex-wrap mt-1 mt-md-0"></div>
                </div>
                <canvas id="income-chart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">Overall sales</h6>
              <div class="dropdown">
                <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button"
                  id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Last 30 days
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                  <h6 class="dropdown-header">Settings</h6>
                  <a class="dropdown-item" href="javascript:;">Action</a>
                  <a class="dropdown-item" href="javascript:;">Another action</a>
                  <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <canvas id="sales-chart-c" class="mt-2"></canvas>
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 mt-4">
              <div class="d-flex flex-column justify-content-center align-items-center">
                <p class="text-muted">Gross Sales</p>
                <h5>492</h5>
                <div class="d-flex align-items-baseline">
                  <p class="text-success mb-0">0.5%</p>
                  <i class="typcn typcn-arrow-up-thick text-success"></i>
                </div>
              </div>
              <div class="d-flex flex-column justify-content-center align-items-center">
                <p class="text-muted">Purchases</p>
                <h5>87k</h5>
                <div class="d-flex align-items-baseline">
                  <p class="text-success mb-0">0.8%</p>
                  <i class="typcn typcn-arrow-up-thick text-success"></i>
                </div>
              </div>
              <div class="d-flex flex-column justify-content-center align-items-center">
                <p class="text-muted">Tax Return</p>
                <h5>882</h5>
                <div class="d-flex align-items-baseline">
                  <p class="text-danger mb-0">-04%</p>
                  <i class="typcn typcn-arrow-down-thick text-danger"></i>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div class="dropdown">
                <button class="btn bg-white p-0 pb-1 pt-1 text-muted btn-sm dropdown-toggle" type="button"
                  id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Last 7 days
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton3">
                  <h6 class="dropdown-header">Settings</h6>
                  <a class="dropdown-item" href="javascript:;">Action</a>
                  <a class="dropdown-item" href="javascript:;">Another action</a>
                  <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
              </div>
              <p class="mb-0">overview</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 grid-margin stretch-card">
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card newsletter-card bg-gradient-warning">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                  <h5 class="mb-3 text-white">Newsletter</h5>
                  <form class="form d-flex flex-column align-items-center justify-content-between w-100">
                    <div class="form-group mb-2 w-100">
                      <input type="text" class="form-control" placeholder="email address">
                    </div>
                    <button class="btn btn-danger btn-rounded mt-1" type="submit">Subscribe</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 stretch-card">
            <div class="card profile-card bg-gradient-primary">
              <div class="card-body">
                <div class="row align-items-center h-100">
                  <div class="col-md-4">
                    <figure class="avatar mx-auto mb-4 mb-md-0">
                      <img src="images/faces/face20.jpg" alt="avatar">
                    </figure>
                  </div>
                  <div class="col-md-8">
                    <h5 class="text-white text-center text-md-left">Phoebe Kennedy</h5>
                    <p class="text-white text-center text-md-left">kennedy@gmail.com</p>
                    <div class="d-flex align-items-center justify-content-between info pt-2">
                      <div>
                        <p class="text-white font-weight-bold">Birth date</p>
                        <p class="text-white font-weight-bold">Birth city</p>
                      </div>
                      <div>
                        <p class="text-white">16 Sep 2019</p>
                        <p class="text-white">Netherlands</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <h6 class="mb-2 mb-md-0 text-uppercase font-weight-medium">Sales statistics</h6>
              <div class="dropdown">
                <button class="btn bg-white p-0 pb-1 text-muted btn-sm dropdown-toggle" type="button"
                  id="dropdownMenuSizeButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Last 7 days
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton4">
                  <h6 class="dropdown-header">Settings</h6>
                  <a class="dropdown-item" href="javascript:;">Action</a>
                  <a class="dropdown-item" href="javascript:;">Another action</a>
                  <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <canvas id="sales-chart-d" height="320"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div
              class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Total Expenses</p>
                <h1 class="mb-0">8742</h1>
              </div>
              <i class="typcn typcn-briefcase icon-xl text-secondary"></i>
            </div>
            <canvas id="expense-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div
              class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Total Budget</p>
                <h1 class="mb-0">47,840</h1>
              </div>
              <i class="typcn typcn-chart-pie icon-xl text-secondary"></i>
            </div>
            <canvas id="budget-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div
              class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Total Balance</p>
                <h1 class="mb-0">$7,243</h1>
              </div>
              <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
            </div>
            <canvas id="balance-chart" height="80"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table">
              <thead>
                <tr>
                  <th class="ml-5">ID</th>
                  <th>Project name</th>
                  <th>Customer</th>
                  <th>Deadline</th>
                  <th>Payouts </th>
                  <th>Traffic</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#D1</td>
                  <td>Consectetur adipisicing elit </td>
                  <td>Beulah Cummings</td>
                  <td>03 Jan 2019</td>
                  <td>$ 5235</td>
                  <td>1.3K</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                        Edit
                        <i class="typcn typcn-edit btn-icon-append"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                        Delete
                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>#D2</td>
                  <td>Correlation natural resources silo</td>
                  <td>Mitchel Dunford</td>
                  <td>09 Oct 2019</td>
                  <td>$ 3233</td>
                  <td>5.4K</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                        Edit
                        <i class="typcn typcn-edit btn-icon-append"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                        Delete
                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>#D3</td>
                  <td>social capital compassion social</td>
                  <td>Pei Canaday</td>
                  <td>18 Jun 2019</td>
                  <td>$ 4311</td>
                  <td>2.1K</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                        Edit
                        <i class="typcn typcn-edit btn-icon-append"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                        Delete
                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>#D4</td>
                  <td>empower communities thought</td>
                  <td>Gaynell Sharpton</td>
                  <td>23 Mar 2019</td>
                  <td>$ 7743</td>
                  <td>2.7K</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                        Edit
                        <i class="typcn typcn-edit btn-icon-append"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                        Delete
                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>#D5</td>
                  <td> Targeted effective; mobilize </td>
                  <td>Audrie Midyett</td>
                  <td>22 Aug 2019</td>
                  <td>$ 2455</td>
                  <td>1.2K</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <button type="button" class="btn btn-success btn-sm btn-icon-text mr-3">
                        Edit
                        <i class="typcn typcn-edit btn-icon-append"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm btn-icon-text">
                        Delete
                        <i class="typcn typcn-delete-outline btn-icon-append"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
@endif

@endsection