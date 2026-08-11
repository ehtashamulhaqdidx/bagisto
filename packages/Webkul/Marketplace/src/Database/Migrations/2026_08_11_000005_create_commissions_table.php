<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->cascadeOnDelete();
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('order_item_id');
            $table->unsignedInteger('invoice_id')->nullable();

            $table->decimal('item_total', 12, 4);
            $table->decimal('commission_rate', 8, 2);
            $table->decimal('commission_amount', 12, 4)->comment('Admin earning');
            $table->decimal('seller_earning', 12, 4);

            $table->enum('status', ['pending', 'payable', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_commissions');
    }
};
