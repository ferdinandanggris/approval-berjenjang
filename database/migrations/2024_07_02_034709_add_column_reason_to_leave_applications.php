<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnReasonToLeaveApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_applications', function (Blueprint $table) {
            $table->text('hr_reason')->nullable()->after('is_approve_hr');
            $table->text('officer_reason')->nullable()->after('is_approve_officer');
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->text('hr_reason')->nullable()->after('is_approve_hr');
            $table->text('officer_reason')->nullable()->after('is_approve_officer');
            $table->text('finance_reason')->nullable()->after('is_approve_finance');
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
            $table->dropColumn('hr_reason');
            $table->dropColumn('officer_reason');
        });

        Schema::table('travel_authorization', function (Blueprint $table) {
            $table->dropColumn('hr_reason');
            $table->dropColumn('officer_reason');
            $table->dropColumn('finance_reason');
        });
    }
}
