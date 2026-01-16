<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_cost')->default(0)->after('total_amount');
            $table->foreignId('shipping_rate_id')->nullable()->after('shipping_cost')->constrained('shipping_rates')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('shipping_rate_id');
            $table->dropColumn('shipping_cost');
        });
    }
};
