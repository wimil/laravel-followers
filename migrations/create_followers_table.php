<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('follow.table_name', 'followers'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('follower');
            $table->nullableMorphs('followable');
            $table->dateTime('created_at')->nullable();

            $table->unique(['follower_type', 'follower_id', 'followable_type', 'followable_id'], 'morph_unique');
            //$table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('followers.table_name', 'followers'));
    }
}
