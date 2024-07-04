<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;

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

    public function delete($id)
    {
        LeaveRequest::findOrFail($id)->delete();
        session()->flash('success', 'Leave request deleted successfully.');
    }

    public function print($id)
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($id);

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Load your template Word document
        $templatePath = public_path('\SuratTugasPerjalananDinas.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Replace placeholders in the template with actual data
        $templateProcessor->setValue('Name', $leaveRequest->name);
        $templateProcessor->setValue('NIK', $leaveRequest->nik);
        $templateProcessor->setValue('Position', $leaveRequest->position);
        $templateProcessor->setValue('Start', $leaveRequest->start_date);
        $templateProcessor->setValue('End', $leaveRequest->end_date);
        $templateProcessor->setValue('Destination', $leaveRequest->destination_place);
        $templateProcessor->setValue('Purpose', $leaveRequest->activity_purpose);
        // Add more replacements as needed

        // Generate a filename for the output Word document
        $outputFileName = 'leave_request_' . $leaveRequest->id . '.docx';

        // Save the generated document
        $outputFilePath = public_path('\leave_requests' . $outputFileName);
        $templateProcessor->saveAs($outputFilePath);

        // Example: Return a response with the generated Word document for download
        return response()->download($outputFilePath, $outputFileName)->deleteFileAfterSend(true);
    }
}
