<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->tinyInteger('is_approve_officer')->default(0)->after('status');
            $table->tinyInteger('is_approve_hr')->default(0)->after('is_approve_officer');
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->tinyInteger('is_approve_officer')->default(0)->after('status');
            $table->tinyInteger('is_approve_hr')->default(0)->after('is_approve_officer');
            $table->tinyInteger('is_approve_finance')->default(0)->after('is_approve_hr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->dropColumn('is_approve_officer');
            $table->dropColumn('is_approve_hr');
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->dropColumn('is_approve_officer');
            $table->dropColumn('is_approve_hr');
            $table->dropColumn('is_approve_finance');
        });
    }
}
