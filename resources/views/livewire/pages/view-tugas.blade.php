<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>List Tugas</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Detail Tugas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Tempat</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas as $index => $leaveRequest)
                        <tr>
                            <td>{{ $leaveRequest->name }}</td>
                            <td>{{ $leaveRequest->nik }}</td>
                            <td>{{ $leaveRequest->position }}</td>
                            <td>{{ $leaveRequest->start_date }}</td>
                            <td>{{ $leaveRequest->end_date }}</td>
                            <td>{{ $leaveRequest->destination_place }}</td>
                            <td>{{ $leaveRequest->activity_purpose }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $tugas->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $().tooltip();
</script>