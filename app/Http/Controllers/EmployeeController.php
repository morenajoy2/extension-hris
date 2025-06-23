<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Requirement;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'department', 'departmentTeam', 'position']); // eager load relations

        // Search filter
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('employee_id', 'like', "%$search%")
                  ->orWhere('school', 'like', "%$search%");
            });
        }

        // Filter by latest, oldest, active, exited
        switch ($request->filter) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'active':
                $query->where('status', 'Active');
                break;
            case 'exited':
                $query->where('status', 'Exited');
                break;
        }

        $employees = $query->paginate(10);

        // Add completion rate per user (if method exists on model)
        foreach ($employees as $employee) {
            $employee->completion_rate = $employee->completionRate();
        }

        return view('employees.index', compact('employees'));
    }

    public function show(User $user)
    {
        $requirements = Requirement::where('user_id', $user->id)->get();

        $allTypes = config('requirements.required_types') ?? [];

        $otherRequirements = $requirements->filter(function ($req) use ($allTypes) {
            return !in_array($req->type, $allTypes);
        });

        return view('employees.show', compact('user', 'requirements', 'allTypes', 'otherRequirements'));
    }

    public function edit(User $user)
    {
        // Optional: load related data for dropdowns (roles, departments, etc.)
        return view('employees.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'school'     => 'nullable|string|max:255',
            'status'     => 'required|in:Active,Exited',
            // Add validation if updating foreign keys (optional)
            // 'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $newStatus = ucfirst(strtolower($request->input('status'))); // Ensure proper casing

        if (!in_array($newStatus, ['Active', 'Exited'])) {
            return back()->withErrors(['Invalid status.']);
        }

        $user->status = $newStatus;
        $user->save();

        return back()->with('success', 'Status updated successfully.');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query');

        $users = User::where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%")
                    ->orWhere('school', 'like', "%{$search}%")
                    ->limit(5)
                    ->get(['id', 'first_name', 'last_name', 'employee_id', 'school']);

        return response()->json($users);
    }
}
