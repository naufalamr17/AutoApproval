<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

Carbon::setLocale('id');

class ViewTugas extends Component
{
    use WithPagination;

    public $searchTerm;

    public $sortColumn = 'id'; // Default sorting column
    public $sortDirection = 'asc'; // Default sorting direction
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['searchTerm'];

    public $leaveRequestId;
    public $no;
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
        'activity_purpose' => 'required|string|max:255',
    ];

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumn = $column;
    }

    public function sortIcon($column)
    {
        if ($this->sortColumn === $column) {
            return $this->sortDirection === 'asc' ? '↑' : '↓';
        }
        return '';
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        $query = LeaveRequest::query()
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('no', 'like', $searchTerm)
                    ->orWhere('nik', 'like', $searchTerm)
                    ->orWhere('position', 'like', $searchTerm)
                    ->orWhere('destination_place', 'like', $searchTerm)
                    ->orWhere('activity_purpose', 'like', $searchTerm);
            });

        if ($this->statusFilter) {
            $query->where('status', 'like', $this->statusFilter . '%');
        }

        $tugas = $query->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.pages.view-tugas', [
            'tugas' => $tugas,
        ]);
    }

    public function delete($id)
    {
        LeaveRequest::findOrFail($id)->delete();
        session()->flash('success', 'Leave request deleted successfully.');
    }

    public function print($id)
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($id);

        Carbon::setLocale('id');

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Load your template Word document
        $templatePath = public_path('\SuratTugasPerjalananDinas.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Path ke gambar yang akan disisipkan
        $imagePath = public_path('\mlp.jpeg');

        // Replace placeholders in the template with actual data
        $templateProcessor->setValue('No', $leaveRequest->no);
        $templateProcessor->setValue('Name', $leaveRequest->name);
        $templateProcessor->setValue('NIK', $leaveRequest->nik);
        $templateProcessor->setValue('Position', $leaveRequest->position);
        $startDate = Carbon::parse($leaveRequest->start_date)->translatedFormat('d F Y');
        $endDate = Carbon::parse($leaveRequest->end_date)->translatedFormat('d F Y');
        $templateProcessor->setValue('Start', $startDate);
        $templateProcessor->setValue('End', $endDate);
        $templateProcessor->setValue('Destination', $leaveRequest->destination_place);
        $templateProcessor->setValue('Purpose', $leaveRequest->activity_purpose);
        $templateProcessor->setValue('Region', $leaveRequest->region);
        if ($leaveRequest->status == 'Waiting Approval') {
            $templateProcessor->setValue('Sign', "");
            $templateProcessor->setValue('Date', "");
        } else {
            $templateProcessor->setImageValue('Sign', array('path' => $imagePath, 'width' => 70, 'height' => 70, 'ratio' => true));

            $status = $leaveRequest->status;

            // Extract timestamp substring
            $timestamp = substr($status, strpos($status, ' at ') + 4, 19);

            // Parse date usixng Carbon
            $date = Carbon::parse($timestamp);

            // Format the date as needed
            $formattedDate = $date->translatedFormat('d F Y');

            $templateProcessor->setValue('Date', $formattedDate);
        }
        $templateProcessor->setValue('Year', Carbon::now()->year);
        // Add more replacements as needed

        // Generate a filename for the output Word document
        $outputFileName = 'Surat Tugas ' . $leaveRequest->name . '.docx';

        // Save the generated document
        $outputFilePath = public_path('\leave_requests' . $outputFileName);
        $templateProcessor->saveAs($outputFilePath);

        // Example: Return a response with the generated Word document for download
        return response()->download($outputFilePath, $outputFileName)->deleteFileAfterSend(true);
    }

    public function approve($id)
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($id);

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Approve the leave request (this could be setting a status or other logic)
        $leaveRequest->status = 'Approved by ' . Auth::user()->name . ' at ' . Carbon::now() . ' WIB';
        $leaveRequest->save();

        // Optionally, you can add some flash message to notify the user
        session()->flash('success', 'Leave request approved successfully.');

        // You can redirect or just refresh the page
        return redirect()->back();
    }

    public function reject($id)
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($id);

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Approve the leave request (this could be setting a status or other logic)
        $leaveRequest->status = 'Rejected by ' . Auth::user()->name . ' at ' . Carbon::now() . ' WIB';
        $leaveRequest->save();

        // Optionally, you can add some flash message to notify the user
        session()->flash('success', 'Leave request rejected successfully.');

        // You can redirect or just refresh the page
        return redirect()->back();
    }

    public function edit($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $this->leaveRequestId = $leaveRequest->id;
        $this->no = $leaveRequest->no;
        $this->name = $leaveRequest->name;
        $this->nik = $leaveRequest->nik;
        $this->position = $leaveRequest->position;
        $this->start_date = $leaveRequest->start_date;
        $this->end_date = $leaveRequest->end_date;
        $this->destination_place = $leaveRequest->destination_place;
        $this->activity_purpose = $leaveRequest->activity_purpose;
    }

    public function update()
    {
        $this->validate();

        $leaveRequest = LeaveRequest::findOrFail($this->leaveRequestId);
        $leaveRequest->update([
            'name' => $this->name,
            'nik' => $this->nik,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'destination_place' => $this->destination_place,
            'activity_purpose' => $this->activity_purpose,
            'status' => 'Waiting Approval',
        ]);

        session()->flash('success', 'Leave request successfully updated.');

        $this->reset();
    }
}
