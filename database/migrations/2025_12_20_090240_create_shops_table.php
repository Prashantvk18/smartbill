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
       Schema::create('shops', function (Blueprint $table) {
        $table->id();
        $table->string('shop_name');

        $table->unsignedBigInteger('owner_id');
        $table->unsignedBigInteger('created_by');
        $table->unsignedBigInteger('updated_by');

        $table->boolean('is_paid')->default(0);
        $table->decimal('paid_amount', 10, 2)->default(0);
        $table->date('dop')->nullable(); // date of payment
        $table->date('doe')->nullable(); // date of expiry

        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
