<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('dob');
            $table->string('address_line')->nullable()->after('gender');
            $table->string('city', 100)->nullable()->after('address_line');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('postcode', 20)->nullable()->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'address_line',
                'city',
                'state',
                'postcode',
            ]);
        });
    }
};