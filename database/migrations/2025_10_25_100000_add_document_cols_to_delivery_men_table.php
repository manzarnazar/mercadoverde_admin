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
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->string('driver_license_image')->nullable();
            $table->string('curp_rfc')->nullable();
            $table->string('curp_rfc_certificate_image')->nullable();
            $table->string('cofepris_document_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropColumn(['driver_license_image', 'curp_rfc', 'curp_rfc_certificate_image', 'cofepris_document_image']);
        });
    }
};
