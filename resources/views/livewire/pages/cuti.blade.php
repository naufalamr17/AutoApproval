<div>
    @include('livewire.utilities.alerts')
    <x-slot name="header">
        <div class="section-header">
            <h1>Pendataan Cuti</h1>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Masukkan Detail Cuti</h4>
        </div>
        <div class="card-body">
            <!-- Name -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="form-group">
                <x-label for="name" :value="__('Nama')" />
                <x-input id="name" type="text" name="name" :value="old('name')" wire:model='name' />
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" type="email" name="email" :value="old('email')" wire:model='email' />
            </div>

            <!-- Tanggal Mulai Cuti dan Tanggal Selesai Cuti -->
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <x-label for="start_date" :value="__('Tanggal Mulai Cuti')" />
                        <x-input id="start_date" type="date" name="start_date" :value="old('start_date')" wire:model='start_date' />
                    </div>
                    <div class="col-6">
                        <x-label for="end_date" :value="__('Tanggal Selesai Cuti')" />
                        <x-input id="end_date" type="date" name="end_date" :value="old('end_date')" wire:model='end_date' />
                    </div>
                </div>
            </div>

            <!-- Alasan Cuti -->
            <div class="form-group">
                <x-label for="reason" :value="__('Alasan Cuti')" />
                <textarea id="reason" name="reason" class="form-control" rows="4" wire:model='reason'></textarea>
            </div>

            <!-- Submit Button -->
            <x-button type='submit' wire:click='addUser'>
                {{ __('Ajukan Cuti') }}
            </x-button>
        </div>
    </div>
</div>