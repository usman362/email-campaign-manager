<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Imports\ProfessorsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        $professors = Professor::orderBy('created_at', 'desc')->paginate(20);
        return view('professors.index', compact('professors'));
    }

    public function create()
    {
        return view('professors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:professors',
            'university' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        Professor::create($validated);

        return redirect()->route('professors.index')
            ->with('success', 'Professor Created Successfully!');
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email,'.$professor->id,
            'university' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        $professor->update($validated);

        return redirect()->route('professors.index')
            ->with('success', 'Professor Updated Successfully!');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professors.index')
            ->with('success', 'Professor Deleted Successfully!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        Professor::truncate();
        Excel::import(new ProfessorsImport, $request->file('file'));

        return redirect()->route('professors.index')
            ->with('success', 'Excel File Imported Successfully!');
    }
}
