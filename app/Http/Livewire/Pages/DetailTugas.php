<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class DetailTugas extends Component
{
    public $tugasId;
    public $tugas;

    public function mount($id)
    {
        $this->tugasId = $id;
        $this->tugas = LeaveRequest::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pages.detail-tugas');
    }

    public function print()
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($this->tugasId);

        Carbon::setLocale('id');

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
        $startDate = Carbon::parse($leaveRequest->start_date)->translatedFormat('d F Y');
        $endDate = Carbon::parse($leaveRequest->end_date)->translatedFormat('d F Y');
        $templateProcessor->setValue('Start', $startDate);
        $templateProcessor->setValue('End', $endDate);
        $templateProcessor->setValue('Destination', $leaveRequest->destination_place);
        $templateProcessor->setValue('Purpose', $leaveRequest->activity_purpose);
        // Add more replacements as needed

        // Generate a filename for the output Word document
        $outputFileName = 'Surat Tugas ' . $leaveRequest->name . '.docx';

        // Save the generated document
        $outputFilePath = public_path('\leave_requests' . $outputFileName);
        $templateProcessor->saveAs($outputFilePath);

        // Example: Return a response with the generated Word document for download
        return response()->download($outputFilePath, $outputFileName)->deleteFileAfterSend(true);
    }

    public function approve()
    {
        // Retrieve leave request data based on $id
        $leaveRequest = LeaveRequest::find($this->tugasId);

        // Check if leave request exists
        if (!$leaveRequest) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Approve the leave request (this could be setting a status or other logic)
        $leaveRequest->status = 'Approved by ' . Auth::user()->name;
        $leaveRequest->save();

        // Optionally, you can add some flash message to notify the user
        session()->flash('success', 'Leave request approved successfully.');

        // You can redirect or just refresh the page
        return redirect()->route('view-tugas');
    }
}