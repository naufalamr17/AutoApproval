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
            <div class="card-header-action d-flex">
                <input type="text" class="form-control" placeholder="Search" wire:model="searchTerm" style="height: 42px;">
                <select wire:model="statusFilter" class="form-control ml-2">
                    <option value="">All Status</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Waiting Approval">Waiting Approval</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" wire:click="sortBy('no')" style="cursor: pointer;">
                                Nomor {{ $this->sortIcon('no') }}
                            </th>
                            <th scope="col" wire:click="sortBy('name')" style="cursor: pointer;">
                                Nama {{ $this->sortIcon('name') }}
                            </th>
                            <th scope="col" wire:click="sortBy('nik')" style="cursor: pointer;">
                                NIK {{ $this->sortIcon('nik') }}
                            </th>
                            <th scope="col" wire:click="sortBy('position')" style="cursor: pointer;">
                                Jabatan {{ $this->sortIcon('position') }}
                            </th>
                            <th scope="col" wire:click="sortBy('start_date')" style="cursor: pointer;">
                                Tanggal Mulai {{ $this->sortIcon('start_date') }}
                            </th>
                            <th scope="col" wire:click="sortBy('end_date')" style="cursor: pointer;">
                                Tanggal Selesai {{ $this->sortIcon('end_date') }}
                            </th>
                            <th scope="col" wire:click="sortBy('destination_place')" style="cursor: pointer;">
                                Tempat {{ $this->sortIcon('destination_place') }}
                            </th>
                            <th scope="col" wire:click="sortBy('activity_purpose')" style="cursor: pointer;">
                                Tujuan {{ $this->sortIcon('activity_purpose') }}
                            </th>
                            <th scope="col" wire:click="sortBy('status')" style="cursor: pointer;">
                                Status {{ $this->sortIcon('status') }}
                            </th>
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
                                    @php
                                    $status = $leaveRequest->status;
                                    $rejectedStatus = explode(' by ', $status)[0];
                                    @endphp

                                    @if (trim($rejectedStatus) == 'Approved')
                                    <button class="btn btn-sm btn-secondary" disabled style="cursor: not-allowed;">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-secondary" wire:click="edit({{ $leaveRequest->id }})">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    @endif

                                    @if (trim($rejectedStatus) == 'Rejected')
                                    <button class="btn btn-sm btn-success ml-2" disabled style="cursor: not-allowed;">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-success ml-2" wire:click="print({{ $leaveRequest->id }})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    @endif
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

    <!-- Edit Modal -->
    @if ($leaveRequestId)
    <div class="modal fade show" style="display: block; overflow: auto;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave Request</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <label for="no">Nomor</label>
                            <input type="text" id="no" class="form-control" wire:model="no" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" class="form-control" wire:model="nik">
                            @error('nik') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="position">Jabatan</label>
                            <input type="text" id="position" class="form-control" wire:model="position">
                            @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" id="start_date" class="form-control" wire:model="start_date">
                            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="date" id="end_date" class="form-control" wire:model="end_date">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="destination_place">Tempat</label>
                            <input type="text" id="destination_place" class="form-control" wire:model="destination_place">
                            @error('destination_place') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="activity_purpose">Tujuan</label>
                            <input type="text" id="activity_purpose" class="form-control" wire:model="activity_purpose">
                            @error('activity_purpose') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" aria-label="Close" wire:click="$set('leaveRequestId', null)">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #000; opacity: 0.5; z-index: 1040;"></div>
    @endif
</div>
