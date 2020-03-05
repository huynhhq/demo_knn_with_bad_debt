<?php

namespace App\Excels;

use App\Http\Services\CourseServices;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TransactionImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            CourseServices::importCourse( $row );
        }
    }
}
