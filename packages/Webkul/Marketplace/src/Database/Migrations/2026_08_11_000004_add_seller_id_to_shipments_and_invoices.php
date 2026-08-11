<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('shipments')) {
            Schema::table('shipments', function (Blueprint $table) {
                if (! Schema::hasColumn('shipments', 'seller_id')) {
                    $table->foreignId('seller_id')->nullable()->after('order_id')
                        ->constrained('sellers')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (! Schema::hasColumn('invoices', 'seller_id')) {
                    $table->foreignId('seller_id')->nullable()->after('order_id')
                        ->constrained('sellers')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('shipments') && Schema::hasColumn('shipments', 'seller_id')) {
            Schema::table('shipments', fn (Blueprint $t) => $t->dropConstrainedForeignId('seller_id'));
        }
        if (Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'seller_id')) {
            Schema::table('invoices', fn (Blueprint $t) => $t->dropConstrainedForeignId('seller_id'));
        }
    }
};
