<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('token_hash')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('email');
            $table->timestamps();
            $table->unique(['application_id', 'email']);
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->unsignedInteger('term_days');
            $table->unsignedInteger('seat_limit')->default(1);
            $table->boolean('is_trial')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['application_id', 'code']);
        });

        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans');
            $table->string('serial_hash')->unique();
            $table->string('serial_last4', 4);
            $table->enum('type', ['initial', 'renew'])->default('initial');
            $table->enum('status', ['available', 'used', 'void'])->default('available');
            $table->timestamp('used_at_utc')->nullable();
            $table->timestamps();
            $table->index(['application_id', 'status']);
        });

        Schema::create('licenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('issued_serial_number_id')->nullable()->constrained('serial_numbers')->nullOnDelete();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans');
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->timestamp('starts_at_utc');
            $table->timestamp('expires_at_utc');
            $table->timestamp('revoked_at_utc')->nullable();
            $table->timestamps();
            $table->index(['application_id', 'status']);
        });

        Schema::create('license_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('license_id');
            $table->foreign('license_id')->references('id')->on('licenses')->cascadeOnDelete();
            $table->string('token_hash')->unique();
            $table->timestamp('issued_at_utc');
            $table->timestamp('expires_at_utc');
            $table->timestamp('revoked_at_utc')->nullable();
            $table->timestamps();
            $table->index(['license_id', 'expires_at_utc']);
        });

        Schema::create('device_bindings', function (Blueprint $table) {
            $table->id();
            $table->uuid('license_id');
            $table->foreign('license_id')->references('id')->on('licenses')->cascadeOnDelete();
            $table->string('fingerprint_hash');
            $table->string('label');
            $table->string('platform');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('first_seen_at_utc');
            $table->timestamp('deactivated_at_utc')->nullable();
            $table->timestamps();
            $table->index(['license_id', 'status']);
            $table->unique(['license_id', 'fingerprint_hash']);
        });

        Schema::create('trial_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->string('device_hash');
            $table->timestamps();
            $table->unique(['application_id', 'device_hash']);
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('action');
            $table->string('target_type');
            $table->string('target_id');
            $table->json('context_json')->nullable();
            $table->timestamps();
            $table->index(['action', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('trial_claims');
        Schema::dropIfExists('device_bindings');
        Schema::dropIfExists('license_tokens');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('serial_numbers');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('applications');
    }
};
