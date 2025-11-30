<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('year');
            $table->integer('stock')->default(0);
            $table->string('qrcode')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('books');
    }
};
