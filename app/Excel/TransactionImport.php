<?php

namespace App\Excels;

use App\Http\Services\TransactionService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TransactionImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) 
        {
            if( $index == 0 )
                continue;
                
            TransactionService::importTransaction( $row );
        }
    }
}
