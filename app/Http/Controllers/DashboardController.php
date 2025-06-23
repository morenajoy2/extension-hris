<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Requirement;

class DashboardController extends Controller
{
    public function redirectByRole()
    {
        $user = Auth::user();
        $roleName = optional($user->role)->role; // Get role name from related model
        $data = [];

        // HR-specific logic: Department = Management, Team = Corporate Services, Position = HR
        if (
            $roleName !== 'Admin' &&
            optional($user->department)->department_name === 'Management' &&
            optional($user->departmentTeam)->team_name === 'Corporate Services' &&
            optional($user->position)->position_name === 'HR'
        ) {
            $data = $this->getHRSummary($user);
            return view('dashboard.hr', $data);
        }

        // Role-based dashboard redirection
        switch ($roleName) {
            case 'Admin':
                $data = $this->getAdminSummary();
                return view('dashboard.admin', $data);
            case 'Team Leader':
                $data = $this->getTeamLeaderSummary($user);
                return view('dashboard.team-leader', $data);
            case 'Group Leader':
                $data = $this->getGroupLeaderSummary($user);
                return view('dashboard.group-leader', $data);
            case 'Member':
                $data = $this->getMemberSummary($user);
                return view('dashboard.member', $data);
            default:
                abort(403, 'Unauthorized access');
        }
    }

    private function getAdminSummary()
    {
        $requiredTypes = config('requirements.required_types');
        $users = User::all();

        $completedSubmissions = 0;
        $incompleteRequirements = 0;
        $totalFilesUploaded = 0;

        foreach ($users as $user) {
            $uploadedTypes = Requirement::where('user_id', $user->id)
                                        ->where('status', 'Completed')
                                        ->pluck('type')
                                        ->toArray();

            $requiredUploaded = array_intersect($uploadedTypes, $requiredTypes);
            $othersUploaded = array_diff($uploadedTypes, $requiredTypes);

            $uploadedCount = count($requiredUploaded) + count($othersUploaded);
            $totalExpected = count($requiredTypes) + count($othersUploaded);

            $totalFilesUploaded += $uploadedCount;

            if ($uploadedCount >= $totalExpected && $totalExpected > 0) {
                $completedSubmissions++;
            } else {
                $incompleteRequirements++;
            }
        }

        return [
            'totalEmployees' => $users->count(),
            'completedSubmissions' => $completedSubmissions,
            'incompleteRequirements' => $incompleteRequirements,
            'totalFilesUploaded' => $totalFilesUploaded,
            'activeEmployees' => User::where('status', 'Active')->count(),
            'exitedEmployees' => User::where('status', 'Exited')->count(),
        ];
    }

    private function getHRSummary($user)
    {
        $requiredTypes = config('requirements.required_types');
        $allUsers = User::all();

        $completedSubmissions = 0;
        $incompleteRequirements = 0;
        $totalFilesUploaded = 0;

        foreach ($allUsers as $employee) {
            $uploadedTypes = Requirement::where('user_id', $employee->id)
                                        ->where('status', 'Completed')
                                        ->pluck('type')
                                        ->toArray();

            $requiredUploaded = array_intersect($uploadedTypes, $requiredTypes);
            $othersUploaded = array_diff($uploadedTypes, $requiredTypes);

            $uploadedCount = count($requiredUploaded) + count($othersUploaded);
            $totalExpected = count($requiredTypes) + count($othersUploaded);

            $totalFilesUploaded += $uploadedCount;

            if ($uploadedCount >= $totalExpected && $totalExpected > 0) {
                $completedSubmissions++;
            } else {
                $incompleteRequirements++;
            }
        }

        return [
            'totalCorporateMembers' => $allUsers->count(),
            'hrCompletedSubmissions' => $completedSubmissions,
            'hrIncompleteRequirements' => $incompleteRequirements,
            'hrTotalFilesUploaded' => $totalFilesUploaded,
            'hrActiveEmployees' => User::where('status', 'Active')->count(),
            'hrExitedEmployees' => User::where('status', 'Exited')->count(),
        ];
    }

    private function getTeamLeaderSummary($user)
    {
        $departmentId = $user->department_id;
        $requiredTypes = config('requirements.required_types');

        $teamMembers = User::where('department_id', $departmentId)->get();
        $completedSubmissions = 0;
        $incompleteRequirements = 0;

        foreach ($teamMembers as $member) {
            $uploadedTypes = Requirement::where('user_id', $member->id)
                                        ->where('status', 'Completed')
                                        ->pluck('type')
                                        ->toArray();

            $requiredUploaded = array_intersect($uploadedTypes, $requiredTypes);
            $othersUploaded = array_diff($uploadedTypes, $requiredTypes);

            $uploadedCount = count($requiredUploaded) + count($othersUploaded);
            $totalExpected = count($requiredTypes) + count($othersUploaded);

            if ($uploadedCount >= $totalExpected && $totalExpected > 0) {
                $completedSubmissions++;
            } else {
                $incompleteRequirements++;
            }
        }

        return [
            'teamMembersCount' => $teamMembers->count(),
            'teamCompletedSubmissions' => $completedSubmissions,
            'teamIncompleteRequirements' => $incompleteRequirements,
        ];
    }

    private function getGroupLeaderSummary($user)
    {
        $teamId = $user->department_team_id;
        $requiredTypes = config('requirements.required_types');

        $groupMembers = User::where('department_team_id', $teamId)->get();
        $completedSubmissions = 0;
        $incompleteRequirements = 0;

        foreach ($groupMembers as $member) {
            $uploadedTypes = Requirement::where('user_id', $member->id)
                                        ->where('status', 'Completed')
                                        ->pluck('type')
                                        ->toArray();

            $requiredUploaded = array_intersect($uploadedTypes, $requiredTypes);
            $othersUploaded = array_diff($uploadedTypes, $requiredTypes);

            $uploadedCount = count($requiredUploaded) + count($othersUploaded);
            $totalExpected = count($requiredTypes) + count($othersUploaded);

            if ($uploadedCount >= $totalExpected && $totalExpected > 0) {
                $completedSubmissions++;
            } else {
                $incompleteRequirements++;
            }
        }

        return [
            'groupMembersCount' => $groupMembers->count(),
            'groupCompletedSubmissions' => $completedSubmissions,
            'groupIncompleteRequirements' => $incompleteRequirements,
        ];
    }

    private function getMemberSummary($user)
    {
        $requiredTypes = config('requirements.required_types');

        $uploadedTypes = Requirement::where('user_id', $user->id)
                                    ->where('status', 'Completed')
                                    ->pluck('type')
                                    ->toArray();

        $requiredUploaded = array_intersect($uploadedTypes, $requiredTypes);
        $othersUploaded = array_diff($uploadedTypes, $requiredTypes);

        $uploadedCount = count($requiredUploaded) + count($othersUploaded);
        $totalExpected = count($requiredTypes) + count($othersUploaded);

        return [
            'yourCompletedRequirements' => ($uploadedCount >= $totalExpected && $totalExpected > 0) ? $totalExpected : $uploadedCount,
            'yourIncompleteRequirements' => max(0, $totalExpected - $uploadedCount),
        ];
    }
}
