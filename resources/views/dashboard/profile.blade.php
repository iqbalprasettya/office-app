@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Account Settings
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profile settings</h4>
                            <div class="list-group list-group-transparent">
                                <a href="{{ route('profile') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center active">My
                                    Account</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h2 class="mb-4">My Account</h2>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto mb-1">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url({{ $user->avatar ? url('avatars/' . $user->avatar) : 'avatars/default-avatar.png' }})"></span>
                                </div>
                                <div class="col-auto">
                                    <form method="POST" action="{{ route('updateProfile') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" hidden>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $user->name }}" hidden>


                                        {{-- <div class="d-flex"> --}}
                                        <input type="file" name="avatar" class="form-control">

                                        <button type="submit" class="btn mt-1">
                                            Change avatar
                                        </button>
                                        {{-- </div> --}}
                                    </form>
                                </div>
                            </div>
                            <h3 class="card-title">Profile Details</h3>
                            <form method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md">
                                        <div class="form-label">Name</div>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">Email</h3>
                                <p class="card-subtitle">This contact will be shown to others publicly, so choose it
                                    carefully.</p>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-md">
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">Password</h3>
                                <p class="card-subtitle">You can set a permanent password if you don't want to use temporary
                                    login codes.</p>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-md">
                                            <input type="password" name="password" class="form-control"
                                                placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col-md">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
