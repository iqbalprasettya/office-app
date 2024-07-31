@extends('layouts.main')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <form method="POST" action="{{ route('storeReport') }}">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div id="reports">
                                    <div class="report py-3">
                                        <h3 class="card-title pb-2">Add Reports 1</h3>
                                        <div class="row row-cards border-top">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Pengerjaan</label>
                                                    <input type="date" name="reports[0][date]" class="form-control" required>
                                                </div>
                                            </div>
                                            <div id="job-descriptions-0" class="job-descriptions">
                                                <div class="job-description row row-cards">
                                                    <div class="col-md-7">
                                                        <div class="mb-3">
                                                            <label class="form-label">Job Deskripsi</label>
                                                            <textarea name="reports[0][jobs][0][description]" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label">Status Pengerjaan</label>
                                                            <select name="reports[0][jobs][0][status]" class="form-control"
                                                                required>
                                                                <option value="" selected disabled>Pilih Status
                                                                </option>
                                                                <option value="Selesai">Selesai</option>
                                                                <option value="Belum Selesai">Belum Selesai</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-outline-primary add-job my-3"
                                                    data-report-id="0">Add More Job</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-outline-primary" id="add-report">Add More
                                    Report</button>
                                <button type="submit" class="btn btn-primary">Submit Reports</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let reportCount = 1;

            function updateRemoveButtons() {
                document.querySelectorAll('.remove-job').forEach(button => {
                    button.removeEventListener('click', handleRemoveJob);
                    button.addEventListener('click', handleRemoveJob);
                });

                document.querySelectorAll('.remove-report').forEach(button => {
                    button.removeEventListener('click', handleRemoveReport);
                    button.addEventListener('click', handleRemoveReport);
                });
            }

            function handleRemoveJob(event) {
                this.closest('.job-description').remove();
                updateRemoveButtons();
            }

            function handleRemoveReport(event) {
                this.closest('.report').remove();
                updateRemoveButtons();
            }

            document.getElementById('add-report').addEventListener('click', function() {
                const reportTemplate = `
                    <div class="report border-top py-3">
                        <h3 class="card-title pb-2">Add Reports ${reportCount + 1}</h3>
                        <div class="row row-cards">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengerjaan</label>
                                    <input type="date" name="reports[${reportCount}][date]" class="form-control" required>
                                </div>
                            </div>
                            <div id="job-descriptions-${reportCount}" class="job-descriptions">
                                <div class="job-description row row-cards">
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label">Job Deskripsi</label>
                                            <textarea name="reports[${reportCount}][jobs][0][description]" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Status Pengerjaan</label>
                                            <select name="reports[${reportCount}][jobs][0][status]" class="form-control" required>
                                                <option value="" selected disabled>Pilih Status</option>
                                                <option value="Selesai">Selesai</option>
                                                <option value="Belum Selesai">Belum Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-outline-primary add-job" data-report-id="${reportCount}">Add More Job</button>
                                <button type="button" class="btn btn-danger remove-report">Remove Report</button>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('reports').insertAdjacentHTML('beforeend', reportTemplate);
                reportCount++;
                updateRemoveButtons();
            });

            document.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('add-job')) {
                    const reportId = event.target.getAttribute('data-report-id');
                    const jobDescriptionsContainer = document.getElementById(
                        `job-descriptions-${reportId}`);
                    const jobCount = jobDescriptionsContainer.querySelectorAll('.job-description').length;
                    const jobDescriptionTemplate = `
                        <div class="job-description row row-cards">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Job Deskripsi</label>
                                    <textarea name="reports[${reportId}][jobs][${jobCount}][description]" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Status Pengerjaan</label>
                                    <select name="reports[${reportId}][jobs][${jobCount}][status]" class="form-control" required>
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Belum Selesai">Belum Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger remove-job">Remove Job</button>
                            </div>
                        </div>
                    `;
                    jobDescriptionsContainer.insertAdjacentHTML('beforeend', jobDescriptionTemplate);
                    updateRemoveButtons();
                }
            });

            updateRemoveButtons();
        });
    </script>

    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}'
            });
        @endif
    </script>
@endsection
