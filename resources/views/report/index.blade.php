@extends('layouts.main')

@section('title', 'Report')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">My Reports</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('createReport') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <input type="text" class="form-control mb-3" id="search" placeholder="Search...">
                        <table class="table mb-2">
                            <thead>
                                <tr>
                                    <th><button class="table-sort" data-sort="sort-date">Tanggal</button></th>
                                    <th><button class="table-sort" data-sort="sort-desc" width="80%">Deskripsi</button></th>
                                    <th><button class="table-sort" data-sort="sort-status">Status</button></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($reports as $report)
                                    <tr>
                                        <td class="sort-date">{{ $report->date }}</td>
                                        <td class="sort-desc" width="80%">
                                            <ul>
                                                @foreach ($report->jobs as $job)
                                                    <li class="mb-2">{{ $job->description }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="sort-status">
                                            <ul class="list-unstyled">
                                                @foreach ($report->jobs as $job)
                                                    <li>
                                                        @if ($job->status == 'Selesai')
                                                            <span
                                                                class="badge badge-outline text-green mb-2">{{ $job->status }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-outline text-yellow mb-2">{{ $job->status }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('reports.edit', $report->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                                class="delete-form" data-id="{{ $report->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <ul class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'owner' || Auth::user()->role == 'admin')
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Export</div>
                        <h2 class="page-title">Export Reports</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-body">
                        <div id="table-default" class="table-responsive">
                            <div class="filter my-3">
                                <form id="filterForm">
                                    @csrf
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="from">From</label>
                                                <input type="date" name="from" id="from" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="to">To</label>
                                                <input type="date" name="to" id="to" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status">Department</label>
                                                <select name="department" id="department" class="form-control" required>
                                                    {{-- if jika role login nya admin --}}
                                                    @if (Auth::user()->role == 'admin')
                                                        {{-- Menampilkan department yang terkait dengan pengguna saat ini --}}
                                                        <option value="{{ Auth::user()->department_id }}" selected>
                                                            {{ $departments->firstWhere('id', Auth::user()->department_id)->name }}
                                                        </option>
                                                    @else
                                                        <option value="" disabled selected>Select Department</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-3">
                                        <button type="button" class="btn btn-outline-primary"
                                            id="exportDisplay">Display</button>
                                        <button type="button" class="btn btn-primary" id="exportData">Export</button>
                                    </div>
                                </form>
                            </div>

                            <table id="viewData" class="table mb-2">
                                <thead>
                                    <tr>
                                        <th><button class="table-sort" data-sort="sort-date">Tanggal</button></th>
                                        <th><button class="table-sort" data-sort="sort-desc">Deskripsi</button></th>
                                        <th><button class="table-sort" data-sort="sort-status">Status</button></th>
                                        <th><button class="table-sort" data-sort="sort-employee">Employee</button></th>
                                        <th><button class="table-sort" data-sort="sort-department">Department</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody"></tbody>
                            </table>
                            <ul class="pagination"></ul>

                            <script>
                                document.getElementById('exportDisplay').addEventListener('click', function() {
                                    const form = document.getElementById('filterForm');
                                    const formData = new FormData(form);
                                    fetch('{{ route('reports.display') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': formData.get('_token'),
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                from: formData.get('from'),
                                                to: formData.get('to'),
                                                department: formData.get('department')
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            const tbody = document.querySelector('#viewData .table-tbody');
                                            tbody.innerHTML = '';

                                            if (data.length === 0) {
                                                Swal.fire({
                                                    icon: 'info',
                                                    title: 'No Data Found',
                                                    text: 'No reports match your search criteria.'
                                                });
                                            } else {
                                                data.forEach(report => {
                                                    report.jobs.forEach(job => {
                                                        const tr = document.createElement('tr');
                                                        tr.innerHTML = `
                        <td class="sort-date">${report.date}</td>
                        <td class="sort-desc">${job.description}</td>
                        <td class="sort-status">${job.status}</td>
                        <td class="sort-employee">${report.user.name}</td>
                        <td class="sort-department">${report.user.department.name}</td>
                    `;
                                                        tbody.appendChild(tr);
                                                    });
                                                });
                                            }
                                        });
                                });


                                document.getElementById('exportData').addEventListener('click', function() {
                                    const form = document.getElementById('filterForm');
                                    const formData = new FormData(form);

                                    fetch('{{ route('reports.export') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': formData.get('_token'),
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                from: formData.get('from'),
                                                to: formData.get('to'),
                                                department: formData.get('department')
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (!data.success) {
                                                Swal.fire({
                                                    icon: 'info',
                                                    title: 'No Data Found',
                                                    text: data.message
                                                });
                                            } else {
                                                // Jika data ada, kirimkan form untuk download
                                                form.action = '{{ route('reports.export') }}';
                                                form.method = 'POST'; // Set method to POST
                                                form.submit();
                                            }
                                        });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


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

        document.addEventListener("DOMContentLoaded", function() {
            const list = new List('table-default', {
                sortClass: 'table-sort',
                listClass: 'table-tbody',
                valueNames: ['sort-date', 'sort-desc', 'sort-status'],
                page: 10,
                pagination: true,
            });

            list.sort('sort-date', {
                order: "desc"
            });

            document.getElementById('search').addEventListener('keyup', function(event) {
                const searchString = event.target.value;
                list.search(searchString);
            });

            // Add event listener for delete buttons
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const form = event.target;
                    const formId = form.getAttribute('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
@endsection
