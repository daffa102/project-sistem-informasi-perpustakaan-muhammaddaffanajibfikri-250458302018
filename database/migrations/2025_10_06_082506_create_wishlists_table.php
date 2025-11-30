<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->uuid('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
             $table->timestamps();
            $table->softDeletes();

             $table->unique(['member_id', 'book_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('wishlists');
    }
};
