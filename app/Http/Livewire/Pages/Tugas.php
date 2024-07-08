<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Livewire\Component;

class Tugas extends Component
{
    public $name;
    public $nik;
    public $position;
    public $start_date;
    public $end_date;
    public $destination_place;
    public $activity_purpose;

    protected $rules = [
        'name' => 'required|string|max:255',
        'nik' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'destination_place' => 'required|string|max:255',
        'activity_purpose' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        // Mendapatkan nomor terakhir
        $lastLeaveRequest = LeaveRequest::latest('id')->first();
        $lastNumber = $lastLeaveRequest ? intval(substr($lastLeaveRequest->no, -4)) : 0;

        // Mengenerate nomor baru
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $leaveRequest = LeaveRequest::create([
            'no' => now()->format('ym') . $newNumber, // Contoh format: yymm0001
            'name' => $this->name,
            'nik' => $this->nik,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'destination_place' => $this->destination_place,
            'activity_purpose' => $this->activity_purpose,
        ]);

        $leaveRequestId = $leaveRequest->id;
        $routing = route('detail-tugas', ['id' => $leaveRequestId]);

        // dd($routing);

        // Reset form fields
        $this->reset();

        session()->flash('success', 'Leave request successfully submitted.');
    }

    public function render()
    {
        return view('livewire.pages.tugas');
    }
}
