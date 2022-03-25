<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBirthdateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('clients', function (Blueprint $table) {
            // change birthdate column type
            $table->dropColumn(['birthdate']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('clients', function (Blueprint $table) {
            // Remove Address fields
            $table->string('birthdate', 10)->nullable()->after('name');
        });
    }
}
