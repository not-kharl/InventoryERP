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
        Schema::create('receipts', function (Blueprint $table) {
            $table->string('status')->default('Pending');
            $table->id('receiptId');
            $table->unsignedBigInteger('poId')->nullable();
            $table->string('poNumber');
            $table->string('supplierName');
            $table->timestamp('receiptDate')->useCurrent();
            $table->integer('receivedBy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
