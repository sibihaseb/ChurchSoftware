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
        Schema::create('service_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_invoice_id')->constrained('service_invoices')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null'); // Product may be optional
            $table->text('description')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('church_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_invoice_items');
    }
};
