<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('address')->after('password');
            $table->enum('language',['en','es'])->default('es');
            $table->string('register_code')->after('address');
            $table->boolean('confirmed')->after('register_code');
        });

        //Schema::table('users', function (Blueprint $table) {
            //
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('address');
            $table->dropColumn('register_code');
            $table->dropColumn('confirmed');

        });

        //Schema::table('users', function (Blueprint $table) {
            //
        //});
    }
}
