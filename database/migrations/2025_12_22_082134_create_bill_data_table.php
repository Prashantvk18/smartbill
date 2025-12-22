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
        Schema::create('bill_data', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shop_id');

            $table->string('customer_name')->nullable();
            $table->string('bill_no')->unique();
            $table->date('bill_date');

            $table->string('whatsapp_number', 15)->nullable();

            $table->boolean('is_warranty')->default(0);
            $table->boolean('is_guarantee')->default(0);
            $table->text('details')->nullable();

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);

            $table->boolean('is_sign')->default(0);
            $table->boolean('is_stamp')->default(0);

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('pdf_send')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_data');
    }
};
