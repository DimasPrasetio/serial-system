<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('original_price')->nullable();
            $table->unsignedBigInteger('price');
            $table->string('period');
            $table->unsignedInteger('period_months');
            $table->string('badge')->nullable();
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('features');
            $table->string('cta_text')->default('Pilih Paket');
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->unique(['application_id', 'slug']);
            $table->index(['application_id', 'is_active', 'sort_order']);
        });

        Schema::create('landing_installers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('version');
            $table->text('download_url');
            $table->string('platform')->default('windows');
            $table->decimal('file_size_mb', 8, 1)->nullable();
            $table->text('release_notes')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamp('released_at')->nullable();
            $table->timestamps();

            $table->unique('application_id');
        });

        Schema::create('landing_trial_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->unsignedInteger('duration_days')->default(7);
            $table->string('features_included')->default('full');
            $table->string('cta_text')->default('Download Gratis');
            $table->string('cta_subtext')->default('Trial {duration_days} hari penuh fitur inti');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('application_id');
        });

        Schema::create('landing_contact_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('whatsapp_number', 30);
            $table->string('whatsapp_display', 50);
            $table->string('whatsapp_cta_text')->default('Tanya & Order');
            $table->text('whatsapp_message_template');
            $table->string('email')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->timestamps();

            $table->unique('application_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_contact_settings');
        Schema::dropIfExists('landing_trial_settings');
        Schema::dropIfExists('landing_installers');
        Schema::dropIfExists('landing_pricing_plans');
    }
};
