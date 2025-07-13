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
        Schema::create('complaint_suggestions', function (Blueprint $table) {
            $table->id();
            $table->text('feedback');
            $table->char('type');
            $table->integer('rating')->check('rating BETWEEN 1 AND 5');
            // $table->text('review');
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->text('reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_suggestions');
    }
};
