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
        Schema::create('service_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade'); // Assuming 'members' table exists
            $table->string('email')->nullable();
            $table->text('billing_address')->nullable();
            $table->date('sales_receipt_date');
            $table->string('tags')->nullable();
            $table->string('payment_method');
            $table->string('deposit_to');
            $table->string('church_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_invoices');
    }
};
