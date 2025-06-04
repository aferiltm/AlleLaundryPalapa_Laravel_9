<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('transaction_code',7);
            $table->foreignId('status_id')->constrained();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('member_id');
            $table->timestamp('finish_date')->nullable();
            $table->dateTime('estimated_finish_at')->nullable();
            $table->integer('discount');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('member_id')->references('id')->on('users');
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
};
