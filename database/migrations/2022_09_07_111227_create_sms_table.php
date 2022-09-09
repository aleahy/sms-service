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
        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id') //The client who sent the SMS to the SMSService App (incoming)
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('recipient_id') //The client receiving the SMS via a webhook
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('from_phone_number')->nullable();
            $table->string('to_phone_number')->nullable();
            $table->text('message');
            $table->boolean('sent');
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
        Schema::dropIfExists('sms');
    }
};
