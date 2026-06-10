<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'ine_image')) {
                $table->string('ine_image')->nullable();
            }
            if (!Schema::hasColumn('stores', 'ine_back_image')) {
                $table->string('ine_back_image')->nullable();
            }
            if (!Schema::hasColumn('stores', 'cofepris_document_image')) {
                $table->string('cofepris_document_image')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('stores', 'ine_image') ? 'ine_image' : null,
                Schema::hasColumn('stores', 'ine_back_image') ? 'ine_back_image' : null,
                Schema::hasColumn('stores', 'cofepris_document_image') ? 'cofepris_document_image' : null,
            ]);

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
