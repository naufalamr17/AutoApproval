<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Form Surat Tugas</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Masukkan Detail Surat Tugas</h4>
        </div>
        <div class="card-body">
            <!-- NIK -->
            <div class="form-group">
                <x-label for="nik" :value="__('NIK')" />
                <x-input id="nik" type="text" name="nik" :value="$tugas->nik" disabled />
            </div>

            <!-- Nama -->
            <div class="form-group">
                <x-label for="name" :value="__('Nama')" />
                <x-input id="name" type="text" name="name" :value="$tugas->name" disabled />
            </div>

            <!-- Jabatan -->
            <div class="form-group">
                <x-label for="position" :value="__('Jabatan')" />
                <x-input id="position" type="text" name="position" :value="$tugas->position" disabled />
            </div>

            <!-- Tanggal Mulai dan Tanggal Selesai -->
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <x-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-input id="start_date" type="date" name="start_date" :value="$tugas->start_date" disabled />
                    </div>
                    <div class="col-6">
                        <x-label for="end_date" :value="__('Tanggal Selesai')" />
                        <x-input id="end_date" type="date" name="end_date" :value="$tugas->end_date" disabled />
                    </div>
                </div>
            </div>

            <!-- Tujuan Tempat -->
            <div class="form-group">
                <x-label for="destination_place" :value="__('Tujuan Tempat')" />
                <x-input id="destination_place" type="text" name="destination_place" :value="$tugas->destination_place" disabled />
            </div>

            <!-- Tujuan Kegiatan -->
            <div class="form-group">
                <x-label for="activity_purpose" :value="__('Tujuan Kegiatan')" />
                <textarea id="activity_purpose" name="activity_purpose" class="form-control" rows="4" disabled>{{ $tugas->activity_purpose }}</textarea>
            </div>

            <!-- Status -->
            <div class="form-group">
                <x-label for="status" :value="__('Status')" />
                <x-input id="status" type="text" name="status" :value="$tugas->status" disabled />
            </div>

            <div class="form-group d-flex">
                @php
                $status = $tugas->status;
                $rejectedStatus = explode(' by ', $status)[0];
                @endphp

                @if (trim($rejectedStatus) == 'Rejected')
                <button class="btn btn-success" disabled style="cursor: not-allowed;">
                    <i class="fas fa-print"></i>
                </button>
                @else
                <button class="btn btn-success" wire:click="print">
                    <i class="fas fa-print"></i>
                </button>
                @endif
                @if ($tugas->status == 'Waiting Approval')
                <button class="btn btn-primary ml-2" wire:click="approve">
                    <i class="fas fa-check-circle"></i>
                </button>
                <button class="btn btn-danger ml-2" wire:click="reject">
                    <i class="fas fa-times-circle"></i>
                </button>
                @else
                <button class="btn btn-primary ml-2" disabled style="cursor: not-allowed;">
                    <i class="fas fa-check-circle"></i>
                </button>
                <button class="btn btn-danger ml-2" disabled style="cursor: not-allowed;">
                    <i class="fas fa-times-circle"></i>
                </button>
                @endif

                <!-- Tombol Kembali -->
                <a href="{{ route('view-tugas') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>