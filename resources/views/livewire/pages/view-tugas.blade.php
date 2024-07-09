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
            <div class="card-header-action">
                <input type="text" class="form-control" placeholder="Search" wire:model="searchTerm">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Tempat</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col">Status</th>
                            <th scope="col" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas as $leaveRequest)
                        <tr>
                            <td>{{ $leaveRequest->no }}</td>
                            <td>{{ $leaveRequest->name }}</td>
                            <td>{{ $leaveRequest->nik }}</td>
                            <td>{{ $leaveRequest->position }}</td>
                            <td>{{ $leaveRequest->start_date }}</td>
                            <td>{{ $leaveRequest->end_date }}</td>
                            <td>{{ $leaveRequest->destination_place }}</td>
                            <td>{{ $leaveRequest->activity_purpose }}</td>
                            <td>{{ $leaveRequest->status }}</td>
                            <td class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-success" wire:click="print({{ $leaveRequest->id }})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    @if ($leaveRequest->status == 'Waiting Approval')
                                    <button class="btn btn-sm btn-primary ml-2" wire:click="approve({{ $leaveRequest->id }})">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ml-2" wire:click="reject({{ $leaveRequest->id }})">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-primary ml-2" disabled style="cursor: not-allowed;">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ml-2" disabled style="cursor: not-allowed;">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-warning ml-2" wire:click="delete({{ $leaveRequest->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="{{ route('detail-tugas', ['id' => $leaveRequest->id]) }}" class="btn btn-sm btn-info ml-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No data available</td>
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