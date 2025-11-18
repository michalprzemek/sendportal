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
        Schema::create('subscription_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('name');
            $table->unsignedBigInteger('subscriber_list_id');
            $table->uuid('uuid')->unique();
            $table->text('html_content')->nullable();
            $table->string('redirect_after_subscribe_url')->nullable();
            $table->string('redirect_after_confirm_url')->nullable();
            $table->unsignedBigInteger('welcome_email_template_id')->nullable();
            $table->boolean('is_captcha_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_forms');
    }
};
