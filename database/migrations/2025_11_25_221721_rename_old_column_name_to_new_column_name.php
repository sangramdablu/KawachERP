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
        Schema::table('tenants', function (Blueprint $table) {
            $table->renameColumn('db_database', 'database');
            $table->renameColumn('db_username', 'username');
            $table->renameColumn('db_host', 'host');
            $table->renameColumn('db_port', 'port');
            $table->renameColumn('db_password', 'password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->renameColumn('db_database', 'database');
            $table->renameColumn('db_username', 'username');
            $table->renameColumn('db_host', 'host');
            $table->renameColumn('db_port', 'port');
            $table->renameColumn('db_password', 'password');
        });
    }
};
