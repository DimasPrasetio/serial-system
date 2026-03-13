<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_contact_settings', function (Blueprint $table) {
            $table->text('whatsapp_order_message_template')->nullable()->after('whatsapp_message_template');
        });

        DB::table('landing_contact_settings')
            ->whereNull('whatsapp_order_message_template')
            ->update([
                'whatsapp_order_message_template' => DB::raw('whatsapp_message_template'),
            ]);
    }

    public function down(): void
    {
        Schema::table('landing_contact_settings', function (Blueprint $table) {
            $table->dropColumn('whatsapp_order_message_template');
        });
    }
};
