<?php

namespace App\Imports;

use App\Models\JobTitle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobTitlesImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JobTitle([
                'ar' => [
                    'name' => $row['name_ar']
                ],
                'en' => [
                    'name' => $row['name_en']
                ]
        ]);
    }
}
