@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create a New Email Campaign</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('campaigns.store') }}" id="campaignForm" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Campaign Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                    </div>
                    <div class="col-md-6">
                        <label for="template_id" class="form-label">Select template</label>
                        <select class="form-select" id="template_id" name="template_id" required>
                            <option value="">-- Select template --</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="excel_file" class="form-label">Upload Excel File</label>
                    <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv"
                        required>
                    <small class="text-muted">The file should contain the professors' details (name, email, etc.)</small>
                </div>

                <button type="submit" class="btn btn-primary" id="submitBtn">Start Campaign</button>
            </form>
            <div class="progress mt-3 d-none" id="uploadProgressContainer">
                <div class="progress-bar" id="uploadProgressBar" role="progressbar" style="width: 0%">0%</div>
            </div>

            <div id="statusMessage" class="mt-2"></div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('campaignForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const progressContainer = document.getElementById('uploadProgressContainer');
                const progressBar = document.getElementById('uploadProgressBar');
                const statusMessage = document.getElementById('statusMessage');

                progressContainer.classList.remove('d-none');
                progressBar.style.width = '0%';
                progressBar.textContent = '0%';
                statusMessage.innerHTML = `<div class="text-info">⏳ Campaign In Progress...</div>`;

                const xhr = new XMLHttpRequest();

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        const total = response.total || 1;
                        let sent = 0;

                        const interval = setInterval(() => {
                            sent++;
                            const percent = Math.round((sent / total) * 100);
                            progressBar.style.width = percent + '%';
                            progressBar.textContent = percent + '%';

                            if (sent >= total) {
                                clearInterval(interval);
                                statusMessage.innerHTML =
                                    `<div class="alert alert-success">✅ Campaign completed!</div>`;
                            }
                        }, 300);
                    } else {
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            response = {
                                error: 'Something went wrong.'
                            };
                        }
                        statusMessage.innerHTML =
                            `<div class="alert alert-danger">❌ ${response.error || 'Campaign failed.'}</div>`;
                    }
                };

                xhr.onerror = function() {
                    let response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (e) {
                        response = {
                            error: 'Network error or invalid server response.'
                        };
                    }
                    statusMessage.innerHTML = `<div class="alert alert-danger">❌ ${response.error}</div>`;
                };

                xhr.open('POST', "{{ route('campaigns.store') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.send(formData);
            });
        </script>
    @endpush
@endsection
