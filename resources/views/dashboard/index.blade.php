<!-- resources/views/dashboard.blade.php -->
@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Attendance
                    </h2>
                </div>
                <!-- Page title actions -->
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards flex-lg-row-reverse">
                <div class="col-md-6 col-lg-4">
                    <div class="card card-sponsor">
                        <div class="card-body row">
                            <div class="attendance-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title m-0">Jadwal Hari Ini</h5>
                                <span
                                    class="badge badge-outline text-primary">{{ \Carbon\Carbon::now()->translatedFormat('D d, M Y') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-stats">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                        <path d="M18 14v4h4" />
                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M15 3v4" />
                                        <path d="M7 3v4" />
                                        <path d="M3 11h16" />
                                    </svg></span>
                            </div>
                            <div class="attendance-time py-3 d-flex align-items-center">
                                <h2 style="font-size: 36px;" class="mx-auto">08.00 <span class="text-secondary">...</span>
                                    17.00</h2>
                            </div>
                            <form id="attendance-form" method="POST" action="{{ route('attendances.toggle') }}">
                                <div class="attendance-button">
                                    @csrf
                                    <button type="button" class="btn btn-primary w-100 h-30"
                                        @if (isset($todayAttendance) && $todayAttendance->check_in !== null && $todayAttendance->check_out !== null) disabled @endif onclick="confirmAttendance()">
                                        @if (isset($todayAttendance) && $todayAttendance->check_out !== null)
                                            Absen Selesai!
                                        @elseif (isset($todayAttendance) && $todayAttendance->check_in !== null)
                                            Absen Keluar
                                        @else
                                            Absen Masuk
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance History</h3>
                        </div>
                        <div class="card-body">
                            {{-- Attendance History --}}
                            <div id="table-default" class="table-responsive">
                                <table id="tableHistoryAttendance" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Total Hours</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($attendances->isEmpty())
                                            <div class="card p-2 m-2 mt-0 shadow-sm">
                                                <p>Tidak ada catatan kehadiran.</p>
                                            </div>
                                        @else
                                            @foreach ($attendances as $attendance)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><span
                                                            class="badge bg-indigo-lt">{{ \Carbon\Carbon::parse($attendance->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                                                    </td>
                                                    <td>{{ $attendance->total_hours }}</td>
                                                    <td>{{ $attendance->check_in }}</td>
                                                    <td>{{ $attendance->check_out }}</td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Attendance Users
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body row">
                            {{-- input select for employee details --}}
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <select class="form-control" id="Department" name="Department">
                                    <option value="">IT</option>
                                    <option value="">HR</option>
                                    <option value="">Finance</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">User</label>
                                <select class="form-control" id="User" name="User">
                                    <option value="">Iqbal Prasetya</option>
                                    <option value="">Ujang Knalpot</option>
                                    <option value="">Asep</option>
                                    <option value="">Iqbal Prasetya</option>
                                </select>
                            </div>                            
                            {{-- button --}}
                            <div class="col-md-12">
                                <a href="" class="btn btn-primary">Find!</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Attendance User info</h3>
                        </div>
                        <div class="card-body">
                            <div class="row ms-auto gap-4">
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Name</div>
                                    <div class="datagrid-content">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs me-2 rounded"
                                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                                            Paweł Kuna
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Role</div>
                                    <div class="datagrid-content">Admin</div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Totally Attendance</div>
                                    <div class="datagrid-content">20</div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Port number</div>
                                    <div class="datagrid-content">3306</div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Expiration date</div>
                                    <div class="datagrid-content">–</div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Age</div>
                                    <div class="datagrid-content">15 days</div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Edge network</div>
                                    <div class="datagrid-content">
                                        <span class="status status-green">
                                            Active
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Avatars list</div>
                                    <div class="datagrid-content">
                                        <div class="avatar-list avatar-list-stacked">
                                            <span class="avatar avatar-xs rounded"
                                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                                            <span class="avatar avatar-xs rounded">JL</span>
                                            <span class="avatar avatar-xs rounded"
                                                style="background-image: url(./static/avatars/002m.jpg)"></span>
                                            <span class="avatar avatar-xs rounded"
                                                style="background-image: url(./static/avatars/003m.jpg)"></span>
                                            <span class="avatar avatar-xs rounded"
                                                style="background-image: url(./static/avatars/000f.jpg)"></span>
                                            <span class="avatar avatar-xs rounded">+3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Checkbox</div>
                                    <div class="datagrid-content">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <span class="form-check-label">Click me</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <div class="datagrid-title">Icon</div>
                                    <div class="datagrid-content">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                        Checked
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- muncul jika role owner dan admin --}}
    @if (Auth::user()->role == 'owner' || Auth::user()->role == 'admin')
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Overview
                        </div>
                        <h2 class="page-title">
                            Management Users
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-users">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add Users
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-users" aria-label="Create new report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
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
                            <table id="tableUsers" class="table mb-2">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="sort-role">
                                                @if ($user->role == 'admin')
                                                    <span class="badge bg-green text-green-fg">Admin</span>
                                                @elseif ($user->role == 'employee')
                                                    <span class="badge bg-indigo text-indigo-fg">Employee</span>
                                                @elseif ($user->role == 'owner')
                                                    <span class="badge bg-red text-red-fg">Owner</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                {{ $user->department ? $user->department->name : 'N/A' }}</td>


                                            <td>
                                                {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                                            </td>
                                            @if ($user->role == 'admin' || $user->role == 'employee')
                                                <td class="d-flex justify-content-center">
                                                    <a class="btn btn-success btn-icon btn-sm m-1"
                                                        href="{{ route('edit', $user) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </a>
                                                    <form id="delete-user-{{ $user->id }}" method="POST"
                                                        action="{{ route('destroy', $user) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-icon btn-sm m-1" type="button"
                                                            onclick="confirmDelete({{ $user->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            @else
                                                <td class="d-flex justify-content-center">
                                                    <span class="badge bg-azure-lt d-flex align-items-center">Owner <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="currentColor"
                                                            class="icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                                                        </svg></span>
                                                </td>
                                            @endif

                                            <script>
                                                function confirmDelete(userId) {
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: 'You will not be able to recover this user!',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Yes, delete it!',
                                                        cancelButtonText: 'No, keep it'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            document.getElementById('delete-user-' + userId).submit();
                                                        }
                                                    })
                                                }
                                            </script>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal modal-blur fade" id="modal-users" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">New Users</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your Name"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select">
                                        <option value="admin">Admin</option>
                                        <option value="employee" selected>Employee</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- 2 input --}}
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <select name="department_id" class="form-select" required>
                                        <option value="" disabled selected>Choose Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Your Password" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new user
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
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

        function confirmAttendance() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan melakukan absen masuk/keluar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, absen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('attendance-form').submit();
                }
            });
        }

        new DataTable('#tableHistoryAttendance, #tableUsers', {
            responsive: true
        });
    </script>
@endsection
