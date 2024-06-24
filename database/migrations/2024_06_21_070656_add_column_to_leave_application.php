<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLeaveApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable()->after('id');
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_application', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->string('name')->change();
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->string('name')->change();
        });
    }
}
