<!-- resources/views/reports/edit.blade.php -->
@extends('layouts.main')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Edit Report</div>
                    <h2 class="page-title">Update Report</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ $report->date }}" required>
                        </div>

                        <div id="jobs-container">
                            @foreach ($jobs as $index => $job)
                                <div class="job-entry mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <label for="jobs[{{ $index }}][description]"
                                                class="form-label">Deskripsi</label>
                                            <input type="text" id="jobs[{{ $index }}][description]"
                                                name="jobs[{{ $index }}][description]" class="form-control"
                                                value="{{ $job->description }}" required>
                                        </div>
                                        <div class="col">
                                            <label for="jobs[{{ $index }}][status]" class="form-label">Status</label>
                                            <select id="jobs[{{ $index }}][status]"
                                                name="jobs[{{ $index }}][status]" class="form-select" required>
                                                <option value="Selesai" {{ $job->status == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai</option>
                                                <option value="Belum Selesai"
                                                    {{ $job->status == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-job" class="btn btn-primary">Add Job</button>
                        <button type="submit" class="btn btn-success">Update Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-job').addEventListener('click', function() {
            const container = document.getElementById('jobs-container');
            const index = container.children.length;

            const jobEntry = document.createElement('div');
            jobEntry.classList.add('job-entry', 'mb-3');
            jobEntry.innerHTML = `
                <div class="row">
                    <div class="col">
                        <label for="jobs[${index}][description]" class="form-label">Deskripsi</label>
                        <input type="text" id="jobs[${index}][description]" name="jobs[${index}][description]" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="jobs[${index}][status]" class="form-label">Status</label>
                        <select id="jobs[${index}][status]" name="jobs[${index}][status]" class="form-select" required>
                             <option value="" selected disabled>Pilih Status</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Belum Selesai">Belum Selesai</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(jobEntry);
        });
    </script>
@endsection
