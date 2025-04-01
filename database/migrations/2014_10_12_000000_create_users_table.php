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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('code');
            $table->string('email')->unique();
            // $table->string('app_code');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('country_id')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->boolean('status')->default(false);
            $table->string('postal_code')->nullable();
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
