<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->after('serial_last4');
            $table->string('order_note', 500)->nullable()->after('customer_email');
            $table->index('customer_email');
        });
    }

    public function down(): void
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->dropIndex(['customer_email']);
            $table->dropColumn(['customer_email', 'order_note']);
        });
    }
};

