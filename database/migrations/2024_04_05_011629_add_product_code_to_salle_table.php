<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductCodeToSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salle', function (Blueprint $table) {
            $table->string('numero')
                  ->unique()
                  ->after('id_batiment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salle', function (Blueprint $table) {
            $table->dropColumn('numero');
        });
    }
}
