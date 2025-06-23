<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use App\Models\User;
use App\Models\Turnover;
use App\Models\ExitClearance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class RequirementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'other_type' => 'nullable|string|max:255',
            'file' => 'required|file',
            'requires_signature' => 'required|in:Yes,No',

            // Additional fields for application types
            'contact_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'school_address' => 'nullable|string|max:255',

            // For notification types
             'group_id' => 'nullable|exists:groups,id',
             'department_id' => 'nullable|exists:departments,id',
             'position_id' => 'nullable|exists:positions,id',
            'role_id' => 'nullable|exists:roles,id',
            'percent_completed' => 'nullable|in:25,50,75,100',
            'percent_date' => 'nullable|date',
            'total_worked_hours_completed' => 'nullable|integer|min:0',
            'total_worked_hours_required' => 'nullable|integer|min:0',

            // Turnover fields
            'orientation_date' => 'nullable|date',
            'first_day' => 'nullable|date',
            'last_day' => 'nullable|date',
            'exit_day' => 'nullable|date',
            'worked_hours_required' => 'nullable|integer',

            'recommended_employee_id' => 'nullable|integer',
            'recommended_employee_name' => 'nullable|string|max:255',
            'turned_over_tasks' => 'nullable|string',

            'company_accounts_transferred' => 'nullable|string',
            'credentials_handed_over' => 'nullable|string',

            'team_leader_id' => 'nullable|integer',
            'team_leader_name' => 'nullable|string|max:255',
            'corporate_leader_id' => 'nullable|integer',
            'corporate_leader_name' => 'nullable|string|max:255',

            'esignature_turnover_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',

            // Exit Clearance
            'exit_type' => 'nullable|in:Resignation,Termination',
            'turnover_by' => 'nullable|in:Team Leader,Group Leader',
            'turned_over_tasks' => 'nullable|string',

            'file_leader_confirmation' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:51200',
            'file_hr_confirmation' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:51200',
            'esignature_exit_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:51200',

        ]);

        $type = $request->type === 'Others' ? $request->other_type : $request->type;

        // 🔍 Prevent duplicate file upload for the same type
        $existing = Requirement::where('user_id', $request->user_id)
            ->where('type', $type)
            ->first();

        if ($existing && $existing->file) {
            return back()->withErrors([
                'duplicate' => "Requirement \"$type\" has already been uploaded.",
            ]);
        }

        $path = $request->file('file')->store("{$request->user_id}/requirements", 'public');

        $data = [
            'user_id' => $request->user_id,
            'type' => $type,
            'file' => $path,
            'upload_date' => now(),
            'status' => 'Completed',
            'requires_signature' => $validated['requires_signature'],
        ];

        if ($validated['requires_signature'] === 'Yes') {
            $data['signature_status'] = 'Unsigned';
        }

        $requirement = Requirement::updateOrCreate(
            ['user_id' => $request->user_id, 'type' => $type],
            $data
        );

        // Handle Application Form Input
        $applicationTypes = [
            'Resume', 'Photo ID', 'Workstation Photo', 'Internet Speed Photo',
            'PC Specification Photo', 'School ID', 'Signed Consent', 'Valid Signed Consent',
            'Endorsement Letter', 'MOA'
        ];

        if (in_array($type, $applicationTypes)) {
            $user = User::findOrFail($request->user_id);
            $user->update([
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'school' => $request->school,
                'school_address' => $request->school_address,
            ]);
        }

        // Handle Notification Forms Input
        $notificationTypes = ['25% Notification', '50% Notification', '75% Notification', '100% Notification'];

        if (in_array($request->type, $notificationTypes)) {
            DB::table('notification_submissions')->updateOrInsert(
                [
                    'user_id' => $request->user_id, 
                    'percent_completed' => $request->percent_completed
                ],
                [
                    'group_id' => $request->group_id,
                    'department_id'=> $request->department_id,
                    'position_id' => $request->position_id,
                    'role_id' => $request->role_id,
                    'percent_date' => $request->percent_date,
                    'total_worked_hours_completed' => $request->total_worked_hours_completed,
                    'total_worked_hours_required' => $request->total_worked_hours_required,
                    'requirement_id' => $requirement->id,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Turnover form handling
        if ($type === 'Turnover') {
            $esignaturePath = null;

            if ($request->hasFile('esignature_turnover_file')) {
                $esignaturePath = $request->file('esignature_turnover_file')
                    ->store("{$request->user_id}/requirements", 'public');
            }

            // Check if turnover record already exists
            Turnover::updateOrInsert(
                ['user_id' => $request->user_id],
                [
                    'orientation_date' => $request->orientation_date,
                    'first_day' => $request->first_day,
                    'last_day' => $request->last_day,
                    'exit_day' => $request->exit_day,
                    'worked_hours_required' => $request->worked_hours_required,

                    'recommended_employee_id' => $request->recommended_employee_id,
                    'recommended_employee_name' => $request->recommended_employee_name,
                    'turned_over_tasks' => $request->turned_over_tasks,

                    'company_accounts_transferred' => $request->company_accounts_transferred,
                    'credentials_handed_over' => $request->credentials_handed_over,

                    'team_leader_id' => $request->team_leader_id,
                    'team_leader_name' => $request->team_leader_name,
                    'corporate_leader_id' => $request->corporate_leader_id,
                    'corporate_leader_name' => $request->corporate_leader_name,

                    'esignature_turnover_file' => $esignaturePath,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Exit Clearance 
        if ($type === 'Exit Clearance') {
            $fileLeaderPath = null;
            $fileHrPath = null;
            $esignatureExitPath = null;

            if ($request->hasFile('file_leader_confirmation')) {
                $fileLeaderPath = $request->file('file_leader_confirmation')->store("{$request->user_id}/requirements", 'public');
            }

            if ($request->hasFile('file_hr_confirmation')) {
                $fileHrPath = $request->file('file_hr_confirmation')->store("{$request->user_id}/requirements", 'public');
            }

            if ($request->hasFile('esignature_exit_file')) {
                $esignatureExitPath = $request->file('esignature_exit_file')->store("{$request->user_id}/requirements", 'public');
            }

            ExitClearance::create([
                'user_id' => $request->user_id,
                'exit_type' => $request->exit_type,
                'turnover_by' => $request->turnover_by,
                'turned_over_tasks' => $request->turned_over_tasks,
                'file_leader_confirmation' => $fileLeaderPath,
                'file_hr_confirmation' => $fileHrPath,
                'esignature_exit_file' => $esignatureExitPath,
            ]);
        }

        return redirect()->back()->with('success', 'Requirement uploaded successfully!');
    }


    public function delete(Requirement $requirement)
    {
        // Delete uploaded file
        if ($requirement->file) {
            Storage::disk('public')->delete($requirement->file);
        }

        // Delete signed file if exists
        if ($requirement->signed_file) {
            Storage::disk('public')->delete($requirement->signed_file);
        }

        $requiredTypes = config('requirements.required_types') ?? [];

        if (in_array($requirement->type, $requiredTypes)) {
            // Required: reset all fields (not delete row)
            $requirement->update([
                'file' => null,
                'upload_date' => null,
                'status' => 'Incomplete',
                'requires_signature' => 'No',
                'signed_file' => null,
                'signature_status' => 'Unsigned',
                'signed_date' => null,
            ]);
        } else {
            // Optional/Others: delete the row completely
            $requirement->delete();
        }

        return redirect()->route('employees.show', $requirement->user_id)
            ->with('success', 'Requirement deleted successfully.');
    }


    public function myRequirements()
    {
        $user = Auth::user();
        $allTypes = config('requirements.required_types');
        $requirements = Requirement::where('user_id', $user->id)->get();

        return view('employees.show', compact('user', 'requirements', 'allTypes'));
    }

    public function uploadSignedFile(Request $request, Requirement $requirement)
    {
        $request->validate([
            'signed_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:51200', // up to 50MB
        ]);

        // Delete old signed file if exists
        if ($requirement->signed_file) {
            Storage::disk('public')->delete($requirement->signed_file);
        }

        $userId = $requirement->user_id;
        $folder = $userId . '/requirements/signed';
        $filename = time() . '_' . $request->file('signed_file')->getClientOriginalName();
        $filePath = $request->file('signed_file')->store("{$userId}/requirements/signed", 'public');

        $requirement->update([
            'signed_file' => $filePath,
            'signature_status' => 'Signed',
            'signed_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Signed file uploaded successfully.');
    }
}
