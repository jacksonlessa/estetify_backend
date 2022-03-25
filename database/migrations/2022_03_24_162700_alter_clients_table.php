<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClientsTable extends Migration
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
            $table->date('birthdate')->nullable()->after('name');

            // Add Address fields
            $table->string('address', 255)->nullable()->after('email');
            $table->string('neighborhood', 50)->nullable()->after('address');
            $table->string('city', 50)->nullable()->after('neighborhood');
            $table->string('state', 2)->nullable()->after('city');
            $table->string('postal_code', 9)->nullable()->after('state');
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
            $table->dropColumn(['address','neighborhood','city','state','postal_code']);

            // change birthdate column type
            $table->dropColumn(['birthdate']);
        });
    }
}
