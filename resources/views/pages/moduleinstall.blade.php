@extends('layouts.master')

@section('content')

  <div class="card">
    <div class="card-body">
      <h4 class="card-title mb-3">Install Modules To Run Your Organizations</h4>
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
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