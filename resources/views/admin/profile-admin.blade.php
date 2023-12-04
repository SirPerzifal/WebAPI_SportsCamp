@extends('html.html')

@section('content')

    @include('components.header')

    @include('components.sidebar')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('adminDashboardPage') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Admin</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ $dataProfile->foto ? asset('storage/'.$dataProfile->foto) : asset('assets/img/user.png') }}" alt="Profile" class="rounded-circle">
                            <h2 class="text-capitalize">{{ $dataProfile->nama }}</h2>
                            <h3 class="text-capitalize">{{ $dataProfile->user->role }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Kata Sandi</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Profile Details</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nama</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->nama }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->user->email }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nomor Handpone</div>
                                        <div class="col-lg-9 col-md-8">{{ $dataProfile->no_hp }}</div>
                                    </div>
                                </div>
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form action="{{ route('updateProfileAdmin',['id_user' => $dataProfile->id_user]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('put')
                                        <div class="row mb-3">
                                            <label for="fotoProfil" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="foto" type="file" class="form-control mt-2 @error('foto') is-invalid @enderror">
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="nama_bisnis" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama',$dataProfile->nama) }}" required>
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="hidden" name="old_email" value="{{ $dataProfile->user->email }}">
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$dataProfile->user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">Nomor Handphone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror"  value="{{ old('no_hp', $dataProfile->no_hp) }}" required>
                                                @error('no_hp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{ route('updateKataSandi',['id_user' => $dataProfile->id_user]) }}" method="post">
                                        @csrf @method('put')
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Sekarang</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_lama" type="password" class="form-control @error('password_lama') is-invalid @enderror" value="{{ old('password_lama') }}" required>
                                                @error('password_lama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_baru" type="password" class="form-control @error('password_baru') is-invalid @enderror" value="{{ old('password_baru') }}" required>
                                                @error('password_baru')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Ulangi Kata Sandi Baru</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="konf_password" type="password" class="form-control @error('konf_password') is-invalid @enderror" value="{{ old('konf_password') }}" required>
                                                @error('konf_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-main">Ubah Kata Sandi</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    @include('components.footer')
@endsection
