<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Postgres enforces the enum() column via a CHECK constraint, not a
        // native enum type, so adding a new allowed value means dropping and
        // re-adding that constraint with 'expired' included.
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_status_check');
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_status_check CHECK (status IN ('active','out_of_stock','archived','expired'))");
    }

    public function down(): void
    {
        // Reverting requires no rows currently using 'expired'; if any do,
        // update them (e.g. back to 'archived') before rolling back.
        DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_status_check');
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_status_check CHECK (status IN ('active','out_of_stock','archived'))");
    }
};