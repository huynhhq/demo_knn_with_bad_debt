<?php 

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;

use App\Excels\TransactionImport;
use App\Models\Transaction;
use DB;

use App\Http\Services\TransactionService;

class TransactionController extends BaseController
{

    public function index()
    {
        $transactions = Transaction::get();
        return view( 'transactions', compact( 'transactions' ) );
    }

    public function importView()
    {
        return view( 'import' );
    }

    public function import( Request $request )
    {
        Excel::import(new TransactionImport, request()->file('file'));
        return redirect('/du-lieu-giao-dich')->with("success", 'Import thành công.');
    }

    public function stdTransactions()
    {
        $transactions = Transaction::get();

        $std_data = new \stdClass;
        $std_data->max_age = Transaction::max( 'age' );
        $std_data->min_age = Transaction::min( 'age' );
        $std_data->max_income = Transaction::max( 'income' );
        $std_data->min_income = Transaction::min( 'income' );
        $std_data->max_loan_amount = Transaction::max( 'loan_amount' );
        $std_data->min_loan_amount = Transaction::min( 'loan_amount' );
        $std_data->max_tenor = Transaction::max( 'tenor' );
        $std_data->min_tenor = Transaction::min( 'tenor' );
        
        TransactionService::processMinMaxData( $transactions, $std_data );
        return view( 'standardized-transactions', compact( 'transactions' ) );
    }

    public function add()
    {
        return view( 'add-transaction');
    }

    public function save( Request $request )
    {
        $processing_arr = array();

        $input = $request->all();
        $age = $input[ 'age' ];
        $gender = $input[ 'sl-gender' ];
        $education = $input[ 'sl-education' ];
        $marriage = $input[ 'sl-marriage' ];
        $property = $input[ 'sl-property' ];
        $income = $input[ 'income' ];
        $loan_amount = $input[ 'loan_amount' ];
        $tenor = $input[ 'tenor' ];
        $k_number = $input[ 'k_number' ];

        $old_transactions = Transaction::get();

        $transaction = new Transaction;
        $transaction->age = $age;
        $transaction->gender = $gender;
        $transaction->education = $education;
        $transaction->marriage = $marriage;
        $transaction->property = $property;
        $transaction->income = $income;
        $transaction->loan_amount = $loan_amount;
        $transaction->tenor = $tenor;
        $transaction->bad_debt = 0;
        $transaction->k_number = $k_number;
        $transaction->save();

        $std_data = new \stdClass;
        $std_data->max_age = Transaction::max( 'age' );
        $std_data->min_age = Transaction::min( 'age' );
        $std_data->max_income = Transaction::max( 'income' );
        $std_data->min_income = Transaction::min( 'income' );
        $std_data->max_loan_amount = Transaction::max( 'loan_amount' );
        $std_data->min_loan_amount = Transaction::min( 'loan_amount' );
        $std_data->max_tenor = Transaction::max( 'tenor' );
        $std_data->min_tenor = Transaction::min( 'tenor' );

        TransactionService::processMinMax( $transaction, $std_data );

        TransactionService::processMinMaxData( $old_transactions, $std_data );

        for ($i=0; $i < sizeof( $old_transactions ); $i++) {             
            $cur_transaction = $old_transactions[ $i ];

            $tb_age = pow( ( $transaction->std_age - $cur_transaction->std_age ), 2 );

            $tb_gender = 0;
            if( $transaction->gender != $cur_transaction->gender )
                $tb_gender = 1;

            $tb_education = 0;
            if( $transaction->education != $cur_transaction->education )
                $tb_education = 1;

            $tb_marriage = 0;
            if( $transaction->marriage != $cur_transaction->marriage )
                $tb_marriage = 1;

            $tb_property = 0;
            if( $transaction->property != $cur_transaction->property )
                $tb_property = 1;

            $tb_income = pow( ( $transaction->std_income - $cur_transaction->std_income ), 2 );

            $tb_loan_amount = pow( ( $transaction->std_loan_amount - $cur_transaction->std_loan_amount ), 2 );

            $tb_tenor = pow( ( $transaction->std_tenor - $cur_transaction->std_tenor ), 2 );
            
            $value = sqrt( $tb_age + $tb_gender + $tb_education + $tb_marriage + $tb_property + $tb_income + $tb_loan_amount + $tb_tenor );
            
            $obj = new \stdClass();
            $obj->value = $value;
            $obj->id = $cur_transaction->id;

            array_push( $processing_arr, $obj );
        }        

        usort($processing_arr, function($a, $b)
        {
            return strcmp($a->value, $b->value);
        });  
        
        $result= array_slice( $processing_arr, 0, $k_number);
        
        $bad_debt = 0;
        $non_bad_deb = 0;

        foreach ($result as $index => $item) {
            $cur = Transaction::find( $item->id );
            if( $cur->bad_debt == 0 )
            {
                $non_bad_deb++;
            }
            else
            {
                $bad_debt++;
            }
        }

        if( $non_bad_deb > $bad_debt )
        {
            $now_transaction = Transaction::find( $transaction->id );
            $now_transaction->bad_debt = 0;
            $now_transaction->save();
        }
        else if( $non_bad_deb < $bad_debt )
        {
            $now_transaction = Transaction::find( $transaction->id );
            $now_transaction->bad_debt = 1;
            $now_transaction->save();
        }
        else
        {            
            foreach ($result as $index => $item) {
                $item->value = 1 / pow( $item->value, 2);
            }

            usort($result, function($a, $b)
            {
                return strcmp($a->value, $b->value);
            });
            
            $biggest_item = end( $result );
            $cur = Transaction::find( $biggest_item->id );

            $now_transaction = Transaction::find( $transaction->id );
            $now_transaction->bad_debt = $cur->bad_debt;
            $now_transaction->save();
        }
        return redirect( '/du-lieu-giao-dich' );
    }

    public function detail( $id )
    {
        $processing_arr = array();
        $transaction = Transaction::find( $id );

        $k_number = $transaction->k_number;

        $transactions = Transaction::where('id', '!=', $id)->get();
        
        $std_data = new \stdClass;
        $std_data->max_age = Transaction::max( 'age' );
        $std_data->min_age = Transaction::min( 'age' );
        $std_data->max_income = Transaction::max( 'income' );
        $std_data->min_income = Transaction::min( 'income' );
        $std_data->max_loan_amount = Transaction::max( 'loan_amount' );
        $std_data->min_loan_amount = Transaction::min( 'loan_amount' );
        $std_data->max_tenor = Transaction::max( 'tenor' );
        $std_data->min_tenor = Transaction::min( 'tenor' );

        TransactionService::processMinMax( $transaction, $std_data );
        TransactionService::processMinMaxData( $transactions, $std_data );

        for ($i=0; $i < sizeof( $transactions ); $i++) {             
            $cur_transaction = $transactions[ $i ];

            $tb_age = pow( ( $transaction->std_age - $cur_transaction->std_age ), 2 );

            $tb_gender = 0;
            if( $transaction->gender != $cur_transaction->gender )
                $tb_gender = 1;

            $tb_education = 0;
            if( $transaction->education != $cur_transaction->education )
                $tb_education = 1;

            $tb_marriage = 0;
            if( $transaction->marriage != $cur_transaction->marriage )
                $tb_marriage = 1;

            $tb_property = 0;
            if( $transaction->property != $cur_transaction->property )
                $tb_property = 1;

            $tb_income = pow( ( $transaction->std_income - $cur_transaction->std_income ), 2 );

            $tb_loan_amount = pow( ( $transaction->std_loan_amount - $cur_transaction->std_loan_amount ), 2 );

            $tb_tenor = pow( ( $transaction->std_tenor - $cur_transaction->std_tenor ), 2 );
            
            $value = sqrt( $tb_age + $tb_gender + $tb_education + $tb_marriage + $tb_property + $tb_income + $tb_loan_amount + $tb_tenor );
            
            $obj = new \stdClass();
            $obj->value = $value;
            $obj->id = $cur_transaction->id;

            array_push( $processing_arr, $obj );
        }
        
        usort($processing_arr, function($a, $b)
        {
            return strcmp($a->value, $b->value);
        });  
        
        $result= array_slice( $processing_arr, 0, $k_number);

        $data_show = array();

        for ($i=1; $i <=  $k_number ; $i++) { 
            $item = new \stdClass();
            $item->k_number = 'K = ' . $i;
            $item->bad_debt_0 = 0;
            $item->bad_debt_1 = 0;
            $item->user = "";
            for ($j=0; $j < $i; $j++) { 
                $item->user = $item->user . "ID " . $result[ $j ]->id . ", ";
                $rel_transaction = Transaction::find( $result[ $j ]->id );
                if( $rel_transaction->bad_debt == 0 )
                {
                    $item->bad_debt_0++;
                }
                else
                {
                    $item->bad_debt_1++;
                }
            }
            \array_push( $data_show, $item );
        }

        return view( 'detail', compact( 'data_show' ) );
    }

}