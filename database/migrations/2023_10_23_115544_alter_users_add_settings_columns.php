<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddSettingsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('state')->nullable()->after('remember_token');
            $table->string('odds_format')->nullable()->after('state');
            $table->integer('enable_push_notification')->default(0)->after('odds_format');
            $table->text('books_to_exclude')->nullable()->after('enable_push_notification');
            $table->integer('clv_notification_enabled')->default(0)->after('books_to_exclude');
            $table->integer('clv_notification_threshold')->nullable()->after('clv_notification_enabled');
            $table->string('bankroll')->nullable()->after('clv_notification_threshold');
            $table->string('kelly_multiplier')->nullable()->after('bankroll');
            $table->integer('injury_email_notification')->default(0)->after('kelly_multiplier');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('odds_format');
            $table->dropColumn('books_to_exclude');
            $table->dropColumn('clv_notification_enabled');
            $table->dropColumn('clv_notification_threshold');
            $table->dropColumn('bankroll');
            $table->dropColumn('kelly_multiplier');
            $table->dropColumn('injury_email_notification');
        });
    }
}
