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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name')->default('Walk-in Customer');
            $table->date('sale_date');
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('discount',     12, 2)->default(0);
            $table->decimal('vat_rate',      5, 2)->default(5);
            $table->decimal('vat_amount',   12, 2)->default(0);
            $table->decimal('net_amount',   12, 2);
            $table->decimal('paid_amount',  12, 2)->default(0);
            $table->decimal('due_amount',   12, 2)->default(0);
            $table->decimal('cogs',         12, 2)->default(0);
            $table->enum('status', ['paid', 'partial', 'due'])->default('due');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
