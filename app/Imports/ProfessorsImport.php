<?php

namespace App\Imports;

use App\Models\Professor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProfessorsImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Skip the header row
    }

    public function model(array $row)
    {
        return new Professor([
            'name'  => $row[0],
            'email' => $row[1],
            'user_id' => Auth::id()
        ]);
    }
}
