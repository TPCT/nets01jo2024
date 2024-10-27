<?php

namespace App\Exports;

use App\Models\JobTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobTitlesExport implements FromCollection , WithHeadings
{
    public function headings():array {
        return [
            "Id",
            "Name Ar",
            "Name En",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect( JobTitle::getJobTitles() );
    }
}
