@extends('html.html')

@push('js')
<script>
    $(document).ready(function () {
        $('.table').DataTable({
            info: true,
            dom: '<"row"<"col-sm-6 d-flex justify-content-center justify-content-sm-start mb-2 mb-sm-0"l><"col-sm-6 d-flex justify-content-center justify-content-sm-end"f>>rt<"row"<"col-sm-6 mt-0"i><"col-sm-6 mt-2"p>>',
        });
    });
</script>
@endpush

@section('content')

    @include('components.header')

    @include('components.sidebar')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Jenis Lapangan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('superadminDashboardPage') }}">Home</a></li>
                    <li class="breadcrumb-item">Kelola</li>
                    <li class="breadcrumb-item active">Jenis Lapangan</li>
                    </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Kelola Jenis Lapangan</h5>
                            <div class="d-flex justify-content-end mb-2">
                                <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="#TambahModal">
                                    <i class="bi bi-plus-circle-fill"></i> Tambah Jenis Lapangan
                                </button>
                            </div>
                            <table class="table table-striped table-hover border table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenis Lapangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataJenisLapangan as $index => $data )
                                        <tr>
                                            <th>{{ $index+1 }}</th>
                                            <td>{{ $data->jenis_lapangan }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1 justify-content-start">
                                                    <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="#editModal{{ $index+1 }}">
                                                        <i class="bi bi-pen"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $index+1 }}">
                                                        <i class="bi bi-trash3"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="TambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Bank</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahJenisLapangan') }}" method="POST">
                        @csrf
                        <div class="container-fluid">
                            <div class="row gy-2">
                                <div class="col-12">
                                    <label for="" class="mb-2">Jenis Lapangan</label>
                                    <input name="jenis_lapangan" type="text" class="form-control @error('jenis_lapangan') is-invalid @enderror" value="{{ old('jenis_lapangan') }}" required>
                                    @error('jenis_lapangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-main">Simpan</button>
                    </form>
                </div>
        </div>
        </div>
    </div>
    @foreach ($dataJenisLapangan as $index => $data )
        <div class="modal fade" id="editModal{{ $index+1 }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Jenis Lapangan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('editJenisLapangan',['id_jenis_lapangan' => $data->id]) }}" method="POST">
                            @csrf @method('put')
                            <div class="container-fluid">
                                <div class="row gy-2">
                                    <div class="col-12">
                                        <label for="" class="mb-2">Jenis Lapangan</label>
                                        <input name="jenis_lapangan" type="text" class="form-control @error('jenis_lapangan') is-invalid @enderror" value="{{ old('jenis_lapangan', $data->jenis_lapangan) }}" required>
                                        @error('jenis_lapangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-main">Simpan</button>
                        </form>
                    </div>
            </div>
            </div>
        </div>

        <div class="modal fade" id="hapusModal{{ $index+1 }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus Jenis Lapangan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-capitalize">
                            Apakah anda yakin ingin menghapus jenis lapangan <span class="fw-bold text-danger">{{ $data->jenis_lapangan }} ?</span>
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('hapusJenisLapangan',['id_jenis_lapangan' => $data->id]) }}" method="POST">
                            @csrf @method('delete')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
            </div>
            </div>
        </div>
    @endforeach

    @include('components.footer')
@endsection
