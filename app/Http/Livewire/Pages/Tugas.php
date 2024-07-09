<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Carbon\Carbon;
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

        // Mendapatkan tahun, bulan, dan region
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $region = 'jakarta'; // Sesuaikan dengan input atau logic region

        // Mendapatkan nomor terakhir untuk tahun dan region saat ini
        $lastLeaveRequest = LeaveRequest::whereYear('created_at', $currentYear)
            ->where('region', $region) // Pastikan Anda memiliki kolom 'region' di tabel LeaveRequest
            ->latest('id')
            ->first();

        // Mengenerate nomor baru
        $lastNumber = $lastLeaveRequest ? intval(substr($lastLeaveRequest->no, 0, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $monthRoman = $this->getRomanMonth($currentMonth);
        $regionCode = $this->getRegionCode($region);

        // Format nomor surat
        $formattedNo = "$newNumber/$regionCode/$monthRoman/$currentYear";

        // dd($formattedNo);

        // Membuat leave request baru
        $leaveRequest = LeaveRequest::create([
            'no' => $formattedNo,
            'name' => $this->name,
            'nik' => $this->nik,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'destination_place' => $this->destination_place,
            'activity_purpose' => $this->activity_purpose,
            'region' => $region, // Pastikan kolom region tersedia
        ]);

        $leaveRequestId = $leaveRequest->id;
        $routing = route('detail-tugas', ['id' => $leaveRequestId]);

        // Reset form fields
        $this->reset();

        session()->flash('success', 'Leave request successfully submitted.');
    }

    private function getRomanMonth($month)
    {
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $romanMonths[$month];
    }

    private function getRegionCode($region)
    {
        $regionCodes = [
            'jakarta' => 'MLP.STPD-J',
            'kendari' => 'MLP.STPD-KDI',
            'molore' => 'MLP.STPD-SITE'
        ];

        return $regionCodes[$region] ?? 'UNKNOWN';
    }

    public function render()
    {
        return view('livewire.pages.tugas');
    }
}
