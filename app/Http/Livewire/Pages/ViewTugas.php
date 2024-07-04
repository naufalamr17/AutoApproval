<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTugas extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['searchTerm'];

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $tugas = LeaveRequest::where('name', 'like', $searchTerm)
            ->orWhere('nik', 'like', $searchTerm)
            ->orWhere('position', 'like', $searchTerm)
            ->orWhere('destination_place', 'like', $searchTerm)
            ->orWhere('activity_purpose', 'like', $searchTerm)
            ->paginate(10);

        return view('livewire.pages.view-tugas', [
            'tugas' => $tugas,
        ]);
    }
}
