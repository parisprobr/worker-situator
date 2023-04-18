<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
        DB::table('personal_access_tokens')->insert(
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id'   => '1',
                'name'            => 'tokenAdmin',
                //decoded token: 1|eeCnXuk5RNecUDlvQSlthq4OfZNyEPIcDBMEAIbD
                'token'           => '953169f87fe11e7097c2a115d14643dd45528d9ecb666361428c4ec3579113d4',
                'abilities'       => '["*"]',
                'last_used_at'    => '2023-01-26 18:50:07',
                'created_at'      => '2023-01-26 18:36:30',
                'updated_at'      => '2023-01-26 18:36:30',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
