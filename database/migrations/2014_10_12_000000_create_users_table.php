<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            //campos Para login con redes sociales
            $table->string('external_provider')->nullable(); //github, facebook, google...
            $table->string('external_id')->nullable(); //id que nos da github, facebook, google ....
            $table->string('external_token')->nullable(); //token que nos da la red social
            $table->string('external_refresh_token')->nullable(); //si ya estamos validado nos refresca el token cada vez que entramos
            //Final de campos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
