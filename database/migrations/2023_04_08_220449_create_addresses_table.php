<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('addresses', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('network_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->boolean('frozen')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
