<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->after('id')
                ->constrained('sellers')->nullOnDelete();
            $table->enum('approval_status', ['pending', 'approved', 'disapproved'])
                ->default('approved')->after('seller_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('seller_id');
            $table->dropColumn('approval_status');
        });
    }
};
