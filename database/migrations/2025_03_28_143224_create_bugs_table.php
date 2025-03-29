<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'resolved'])->default('open');
            $table->string('priority')->default('low');  // low, medium, high
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Bug reporter
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('bugs');
    }
};
