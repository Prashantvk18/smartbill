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
        Schema::table('bill_data', function (Blueprint $table) {
            $table->boolean('is_pdf')->default(0);
            $table->date('pdf_generate_date')->nullable();
            $table->string('pdf_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_data', function (Blueprint $table) {
            //
        });
    }
};
