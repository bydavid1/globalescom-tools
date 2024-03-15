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
        Schema::table('inputs', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('options');
            $table->string('validations')->nullable()->after('options');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inputs', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('validations');
        });
    }
};
