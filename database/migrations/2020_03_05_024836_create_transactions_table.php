<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('age')->nullable();
            $table->string('gender');
            $table->string('education')->nullable();
            $table->string('marriage')->nullable();
            $table->string('property')->nullable();
            $table->bigInteger('income');
            $table->bigInteger('loan_amount');
            $table->bigInteger('tenor');
            $table->bigInteger('bad_debt');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
