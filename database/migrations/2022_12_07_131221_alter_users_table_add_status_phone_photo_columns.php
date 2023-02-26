<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddStatusPhonePhotoColumns extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('id');
            $table->string('photo')->nullable()->after('status');
            $table->string('phone')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("status");
            $table->dropColumn("photo");
            $table->dropColumn("phone");
        });
    }

}
