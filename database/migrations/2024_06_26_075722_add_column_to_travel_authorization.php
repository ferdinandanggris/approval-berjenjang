<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTravelAuthorization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->bigInteger('officer_id')->nullable()->after('is_approve_officer');
            $table->bigInteger('hr_id')->nullable()->after('is_approve_hr');
            $table->bigInteger('finance_id')->nullable()->after('is_approve_finance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->dropColumn('officer_id');
            $table->dropColumn('hr_id');
            $table->dropColumn('finance_id');
        });
    }
}
