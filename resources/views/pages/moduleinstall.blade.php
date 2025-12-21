@extends('layouts.master')

@section('content')

<style>
    :root {
        --card-bg-light-gray: #f8f9fa;
        /* Lighter background for the entire section */
        --card-item-bg-white: #ffffff;
        /* White background for individual cards */
        --card-text-color: black;
        /* Standard gray text */
        --card-header-gradient-one: linear-gradient(to right top, #ff7e5f, #feb47b);
        /* Example gradient */
        --card-header-gradient-two: linear-gradient(to right top, #8a2be2, #ff00ff);
        /* Example gradient */
        --card-shadow: rgba(0, 0, 0, 0.1);
        --card-hover-shadow: rgba(0, 0, 0, 0.2);
        --card-install-btn-bg: #0d6efd;
        /* Bootstrap primary blue */
        --card-install-btn-hover-bg: #0a58ca;
    }

    .uninstall-btn .progress-bar-inner {
        background: linear-gradient(90deg, #ff416c, #ff4b2b);
    }

    .uninstall-btn.success {
        background: linear-gradient(90deg, #00b09b, #96c93d);
    }

    .install-btn {
        position: relative;
        background: #198754;
        /* Bootstrap success color */
        color: white;
        overflow: hidden;
        border-radius: 3px;
        transition: all 0.3s ease-in-out;
    }

    .install-btn .progress-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .install-btn.active .progress-overlay {
        opacity: 1;
    }

    .progress-bar-inner {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, #00c9a7, #0078ff);
        transition: width 0.2s ease-in-out;
        border-radius: 3px;
        z-index: 1;
    }

    .progress-label {
        position: relative;
        color: white;
        font-weight: bold;
        font-size: 16px;
        z-index: 2;
    }

    .install-btn.success {
        background: linear-gradient(90deg, #00b09b, #96c93d);
    }

    .card-display-section {
        background-color: var(--card-bg-light-gray);
        padding-top: 5rem;
        padding-bottom: 5rem;
        position: relative;
        overflow: hidden;
        /* For rounded corners effect */
        border-top-left-radius: 25px;
        /* Example for a curved top */
        border-top-right-radius: 25px;
        /* Example for a curved top */
    }

    /* Header style - "Cards" text */
    .card-display-header {
        margin-bottom: 3rem;
        padding-bottom: 1rem;
        position: relative;
        z-index: 1;
        /* Ensure text is above any pseudo-elements */
    }

    .card-display-title {
        font-size: 3rem;
        font-weight: bold;
        color: #343a40;
        /* Darker color for the title */
        background: #171717;
        /* background: linear-gradient(to right, #8a2be2, #ff00ff); */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
        /* Essential for text-gradient */
    }

    /* Wavy top background effect for the section */
    .card-display-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        /* Height of the wavy part */
        clip-path: ellipse(120% 60% at 50% 0%);
        /* Creates a wavy top effect */
        z-index: 0;
    }

    .card-display-row {
        margin-top: 2rem;
        /* Give space from the header */
        z-index: 1;
        /* Ensure cards are above background effects */
        position: relative;
    }

    /* Individual Card Styling */
    .card-display-item {
        background-color: var(--card-item-bg-white);
        border: none;
        /* Remove default Bootstrap border */
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--card-shadow);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        overflow: hidden;
        /* Ensure image and content stay within rounded borders */
    }

    /* Hover effect */
    .card-display-item:hover {
        transform: translateY(-8px);
        /* Move slightly up */
        box-shadow: 0 8px 25px var(--card-hover-shadow);
    }

    /* Card 1 specific styles (gradient header) */
    .card-display-item-one .card-display-top-bg-one {
        background: linear-gradient(to right top, #8a2be2, #ff00ff);
        /* Purple/pink gradient */
        padding: 2rem 1.5rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        color: var(--card-item-bg-white);
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .card-display-item-one .card-display-name-one {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .card-display-item-one .card-display-role-one {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .card-display-item-one .card-display-install-btn-one {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: var(--card-item-bg-white);
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 500;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .card-display-item-one .card-display-install-btn-one:hover {
        background-color: rgba(255, 255, 255, 0.4);
        border-color: var(--card-item-bg-white);
    }

    .card-display-item-one .card-display-body-one {
        padding: 1.5rem;
        color: var(--card-text-color);
    }

    .card-display-item-one .card-display-text-one {
        font-size: 0.95rem;
        line-height: 1.6;
    }


    /* Card 2 specific styles (image top) */
    .card-display-item-two .card-display-img-two {
        height: 200px;
        /* Fixed height for consistent image size */
        object-fit: cover;
        /* Ensures image covers area without distortion */
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card-display-item-two .card-display-body-two {
        padding: 1.5rem;
        text-align: center;
    }

    .card-display-item-two .card-display-name-two {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
        color: #343a40;
    }

    .card-display-item-two .card-display-role-two {
        font-size: 0.9rem;
        color: var(--card-text-color);
        margin-bottom: 1rem;
    }

    .card-display-item-two .card-display-text-two {
        font-size: 0.9rem;
        line-height: 1.5;
        color: var(--card-text-color);
        margin-bottom: 1.5rem;
    }

    .card-display-item-two .card-display-install-btn-two {
        background-color: var(--card-install-btn-bg);
        border: none;
        color: var(--card-item-bg-white);
        padding: 0.6rem 1.8rem;
        border-radius: 25px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .card-display-item-two .card-display-install-btn-two:hover {
        background-color: var(--card-install-btn-hover-bg);
    }


    /* Card 3 specific styles (image top, simpler content) */
    .card-display-item-three .card-display-img-three {
        height: 200px;
        /* Fixed height for consistent image size */
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card-display-item-three .card-display-body-three {
        padding: 1.5rem;
    }

    .card-display-item-three .card-display-name-three {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #343a40;
    }

    .card-display-item-three .card-display-text-three {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--card-text-color);
        margin-bottom: 1.5rem;
    }

    .card-display-item-three .card-display-install-btn-three {
        background-color: var(--card-install-btn-bg);
        border: none;
        color: var(--card-item-bg-white);
        padding: 0.6rem 1.8rem;
        border-radius: 25px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .card-display-item-three .card-display-install-btn-three:hover {
        background-color: var(--card-install-btn-hover-bg);
    }

    /* Responsive adjustments for smaller screens */
    @media (max-width: 767.98px) {
        .card-display-title {
            font-size: 2.5rem;
        }

        .card-display-section {
            border-radius: 0;
            /* Remove top border-radius on small screens */
        }

        .card-display-section::before {
            clip-path: ellipse(150% 60% at 50% 0%);
            /* Adjust wave on small screens */
        }
    }
</style>

    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row icons-list">

                            <section class="mt-5 pt-5 pb-5 card-display-section">
                                <div class="container card-display-container">
                                    <div class="card-display-header text-center mb-5">
                                        <h2 class="card-display-title">Get Your Modules</h2>
                                    </div>

                                    <div class="row card-display-row justify-content-center g-4">

                                        @foreach($modules as $module)
                                            <div class="col-lg-4 col-md-6 card-display-col">
                                                <div class="card card-display-item h-100 shadow-sm">
                                                    <img src="https://placehold.co/600x400/00FFFF/FFFFFF?text=Module+Image"
                                                        class="card-img-top card-display-img-three" alt="Card Image">

                                                    <div class="card-body card-display-body-three text-center">
                                                        <h5 class="card-display-name-three">{{ $module->name }}</h5>
                                                        <p class="card-text card-display-text-three">
                                                            {{ $module->description ?? 'No description provided.' }}
                                                        </p>

                                                        @if(in_array($module->id, $installed))
                                                            <button
                                                                class="btn btn-danger btn-sm uninstall-btn position-relative overflow-hidden"
                                                                data-id="{{ $module->id }}" data-name="{{ $module->name }}"
                                                                style="width: 250px; height: 45px; font-weight: 600; font-size: 16px;">
                                                                <span class="install-text">Uninstall</span>
                                                                <div class="progress-overlay">
                                                                    <div class="progress-bar-inner"></div>
                                                                    <span class="progress-label"></span>
                                                                </div>
                                                            </button>
                                                        @else
                                                            <button
                                                                class="btn btn-success btn-sm install-btn position-relative overflow-hidden"
                                                                data-id="{{ $module->id }}" data-name="{{ $module->name }}"
                                                                style="width: 250px; height: 45px; font-weight: 600; font-size: 16px;">
                                                                <span class="install-text">Install</span>
                                                                <div class="progress-overlay">
                                                                    <div class="progress-bar-inner"></div>
                                                                    <span class="progress-label">0%</span>
                                                                </div>
                                                            </button>
                                                        @endif


                                                        {{-- @if(in_array($module->id, $installed))
                                                        <button class="btn btn-secondary btn-sm" disabled>Installed</button>
                                                        @else
                                                        <button
                                                            class="btn btn-success btn-sm install-btn position-relative overflow-hidden"
                                                            data-id="{{ $module->id }}" data-name="{{ $module->name }}"
                                                            style="width: 150px; height: 60px; font-weight: 600; font-size: 16px;">

                                                            <span class="install-text">Install</span>
                                                            <div class="progress-overlay">
                                                                <div class="progress-bar-inner"></div>
                                                                <span class="progress-label">0%</span>
                                                            </div>
                                                        </button>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.install-btn').on('click', function () {
                let btn = $(this);
                let moduleId = btn.data('id');
                let moduleName = btn.data('name');

                showConfirm(
                'Install ' + moduleName + '?',
                'This will install the module into your school database.',
                function (confirmed) {
                    if (confirmed) installModule(moduleId, btn, moduleName);
                }
                );
            });

            function installModule(moduleId, btn, moduleName) {
                const text = btn.find('.install-text');
                const overlay = btn.find('.progress-overlay');
                const bar = btn.find('.progress-bar-inner');
                const label = btn.find('.progress-label');

                btn.addClass('active').prop('disabled', true);
                text.hide();
                overlay.show();

                let progress = 0;
                let fakeProgress = setInterval(() => {
                    if (progress < 90) {
                        progress += Math.floor(Math.random() * 10) + 5;
                        progress = Math.min(progress, 90);
                        bar.css('width', progress + '%');
                        label.text(progress + '%');
                    }
                }, 400);

                $.ajax({
                    url: "{{ route('school.modules.install', ['id' => ':id']) }}".replace(':id', moduleId),
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        clearInterval(fakeProgress);
                        bar.css('width', '100%');
                        label.text('100%');
                        setTimeout(() => {
                            label.text('Installed');
                            btn.addClass('success');
                            bar.css('background', 'linear-gradient(90deg, #00b09b, #96c93d)');
                            showSuccess(
                                'Success',
                                moduleName + ' installed successfully.',
                                function (onClose) {
                                    window.location.reload();
                                }
                            );
                        }, 700);
                    },
                    error: function (xhr) {
                        clearInterval(fakeProgress);
                        bar.css('background', '#dc3545');
                        label.text('Failed');
                        setTimeout(() => {
                            overlay.hide();
                            text.show().text('Retry');
                            btn.removeClass('active').prop('disabled', false);
                            bar.css('width', '0%');
                        }, 1500);
                    }
                });
            }

        });

        $(document).on('click', '.uninstall-btn', function (e) {
            e.preventDefault();
            let btn = $(this);
            let moduleId = btn.data('id');
            let moduleName = btn.data('name');
                showConfirm(
                'Uninstall ' + moduleName + '?',
                'This will remove the module from your school.',
                function (confirmed) {
                    if (confirmed) uninstallModule(moduleId, btn, moduleName);
                }
                );
        });

        function uninstallModule(moduleId, btn, moduleName) {
            const text = btn.find('.install-text');
            const overlay = btn.find('.progress-overlay');
            const bar = btn.find('.progress-bar-inner');
            const label = btn.find('.progress-label');

            btn.addClass('active').prop('disabled', true);
            text.hide();
            overlay.show();

            let progress = 0;
            let fakeProgress = setInterval(() => {
                if (progress < 90) {
                    progress += Math.floor(Math.random() * 10) + 5;
                    progress = Math.min(progress, 90);
                    bar.css('width', progress + '%');
                    label.text(progress + '%');
                }
            }, 400);

            $.ajax({
                url: "{{ route('school.modules.uninstall', ['id' => ':id']) }}".replace(':id', moduleId),
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    clearInterval(fakeProgress);
                    bar.css('width', '100%');
                    label.text('100%');
                    setTimeout(() => {
                        label.text('Uninstalled');
                        btn.addClass('success');
                        bar.css('background', 'linear-gradient(90deg, #00b09b, #96c93d)');
                        setTimeout(() => {
                            btn.replaceWith(`
                            <button 
                                class="btn btn-success btn-sm install-btn position-relative overflow-hidden"
                                data-id="${moduleId}"
                                data-name="${moduleName}"
                                style="width: 150px; height: 60px; font-weight: 600; font-size: 16px;">
                                <span class="install-text">Install</span>
                                <div class="progress-overlay">
                                    <div class="progress-bar-inner"></div>
                                    <span class="progress-label">0%</span>
                                </div>
                            </button>
                        `);
                        }, 1000);
                    }, 700);
                },
                error: function (xhr) {
                    clearInterval(fakeProgress);
                    bar.css('background', '#dc3545');
                    label.text('Failed');
                    setTimeout(() => {
                        overlay.hide();
                        text.show().text('Retry');
                        btn.removeClass('active').prop('disabled', false);
                        bar.css('width', '0%');
                    }, 1500);
                }
            });
        }


    </script>


@endsection