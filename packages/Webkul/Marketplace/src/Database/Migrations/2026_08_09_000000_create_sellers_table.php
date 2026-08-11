<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marketplace_sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('marketplace_seller_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketplace_seller_id');
            $table->string('locale')->index();
            $table->string('shop_title')->nullable();
            $table->text('shop_description')->nullable();
            $table->timestamps();

            $table->foreign('marketplace_seller_id')
                ->references('id')
                ->on('marketplace_sellers')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_seller_translations');
        Schema::dropIfExists('marketplace_sellers');
    }
};
