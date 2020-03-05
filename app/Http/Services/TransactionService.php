<?php

namespace App\Http\Services;
use App\Models\Transaction;

class TransactionService {

    public static function processMinMaxData( &$transactions, $std_data )
    {
        for ($i=0; $i < \sizeof( $transactions ); $i++) { 
            self::processMinMax( $transactions[ $i ], $std_data );
        }
    }

    public static function importTransaction( $row )
    {
        $age = $row[0];        
        $gender = $row[1];
        $education = $row[2];
        $marriage = $row[3];
        $property = $row[4];
        $income = $row[5];
        $loan_amount = $row[6];
        $tenor = $row[7];
        $bad_debt = $row[8];

        $transaction = new Transaction;
        $transaction->age = $age;
        $transaction->gender = $gender;
        $transaction->education = $education;
        $transaction->marriage = $marriage;
        $transaction->property = $property;
        $transaction->income = $income;
        $transaction->loan_amount = $loan_amount;
        $transaction->tenor = $tenor;
        $transaction->bad_debt = $bad_debt;

        $transaction->save();
    }

    public static function processMinMax( &$transaction, $std_data )
    {        
        $transaction->std_age = round( ($transaction->age - $std_data->min_age ) / ( $std_data->max_age - $std_data->min_age ), 2 );        
        $transaction->std_income = round( ($transaction->income - $std_data->min_income ) / ( $std_data->max_income - $std_data->min_income ), 2 );
        $transaction->std_loan_amount = round( ($transaction->loan_amount - $std_data->min_loan_amount ) / ( $std_data->max_loan_amount - $std_data->min_loan_amount ), 2 );
        $transaction->std_tenor = round( ($transaction->tenor - $std_data->min_tenor ) / ( $std_data->max_tenor - $std_data->min_tenor ), 2 );
    }

}