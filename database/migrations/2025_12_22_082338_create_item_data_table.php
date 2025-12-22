<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_data', function (Blueprint $table) {
             $table->id();

            $table->unsignedBigInteger('bill_id');
            $table->string('bill_no');

            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->unsignedBigInteger('added_by');

            $table->timestamps();

            // Optional foreign keys
            // $table->foreign('bill_id')->references('id')->on('bill_data');
            // $table->foreign('added_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_data');
    }
};
