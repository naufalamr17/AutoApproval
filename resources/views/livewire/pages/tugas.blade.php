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
            <!-- Name -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="form-group">
                <x-label for="nik" :value="__('NIK')" />
                <x-input id="nik" type="text" name="nik" :value="old('nik')" wire:model='nik' />
            </div>

            <div class="form-group">
                <x-label for="name" :value="__('Nama')" />
                <x-input id="name" type="text" name="name" :value="old('name')" wire:model='name' />
            </div>

            <!-- Jabatan -->
            <div class="form-group">
                <x-label for="position" :value="__('Jabatan')" />
                <x-input id="position" type="text" name="position" :value="old('position')" wire:model='position' />
            </div>

            <!-- Tanggal Mulai dan Tanggal Selesai -->
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <x-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-input id="start_date" type="date" name="start_date" :value="old('start_date')" wire:model='start_date' />
                    </div>
                    <div class="col-6">
                        <x-label for="end_date" :value="__('Tanggal Selesai')" />
                        <x-input id="end_date" type="date" name="end_date" :value="old('end_date')" wire:model='end_date' />
                    </div>
                </div>
            </div>

            <!-- Tujuan Tempat -->
            <div class="form-group">
                <x-label for="destination_place" :value="__('Tujuan Tempat')" />
                <x-input id="destination_place" type="text" name="destination_place" :value="old('destination_place')" wire:model='destination_place' />
            </div>

            <!-- Tujuan Kegiatan -->
            <div class="form-group">
                <x-label for="activity_purpose" :value="__('Tujuan Kegiatan')" />
                <textarea id="activity_purpose" name="activity_purpose" class="form-control" rows="4" wire:model='activity_purpose'></textarea>
            </div>

            <!-- Submit Button -->
            <x-button type='submit' wire:click='submit'>
                {{ __('Submit') }}
            </x-button>
        </div>
    </div>
</div>