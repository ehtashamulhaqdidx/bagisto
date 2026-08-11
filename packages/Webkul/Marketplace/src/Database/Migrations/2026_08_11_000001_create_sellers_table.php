<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            // Auth
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();

            // Shop profile
            $table->string('shop_title');
            $table->string('shop_url')->unique();
            $table->string('phone')->nullable();
            $table->text('business_description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postcode')->nullable();

            // Marketplace status / commission
            $table->enum('status', ['pending', 'approved', 'disapproved', 'suspended'])->default('pending');
            $table->decimal('commission_rate', 8, 2)->nullable()->comment('Overrides global rate when set');
            $table->boolean('is_featured')->default(false);

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
