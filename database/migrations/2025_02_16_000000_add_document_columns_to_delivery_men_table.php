<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentColumnsToDeliveryMenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->json('curp_rfc_image')->nullable()->after('identity_image');
            $table->json('ine_image')->nullable()->after('curp_rfc_image');
            $table->json('cofepris_image')->nullable()->after('ine_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropColumn(['curp_rfc_image', 'ine_image', 'cofepris_image']);
        });
    }
}
