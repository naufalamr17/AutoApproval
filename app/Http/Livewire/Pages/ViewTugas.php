<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTugas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.view-tugas', [
            'tugas' => LeaveRequest::paginate(5),
        ]);
    }
}
