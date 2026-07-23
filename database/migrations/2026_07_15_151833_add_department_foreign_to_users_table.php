<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration is intentionally left empty because the foreign key
     * constraint on `users.department_id` is already created directly in
     * the `create_users_table` migration via `foreignId(...)->constrained()->nullOnDelete()`.
     * Re-running the same constraint here causes:
     * SQLSTATE[HY000]: General error: 1826 Duplicate foreign key constraint name 'users_department_id_foreign'
     */
    public function up(): void
    {
        // No-op: constraint already exists from create_users_table migration.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: the constraint is dropped automatically when the users table is dropped.
    }
};
