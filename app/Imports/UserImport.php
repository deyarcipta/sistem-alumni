<?php

namespace App\Imports;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * Setiap baris akan diproses ke model Admin.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Abaikan baris yang tidak lengkap
        if (empty($row['nama']) || empty($row['email']) || empty($row['role'])) {
            return null;
        }

        return new Admin([
            'nama'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make('password'), // default
            'foto'     => 'default.jpg',
            'role'     => $row['role'],
        ]);
    }
}
