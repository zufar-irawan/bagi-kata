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
        Schema::create('posts', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();

            //konten
            $table->text('text_content');
            $table->text('image')->nullable();
            $table->text('file')->nullable();

            //buat bikin threads
            $table->foreignUlid('parent_id')->nullable()->constrained('posts')->nullOnDelete();
            $table->foreignUlid('thread_id')->nullable()->constrained('posts')->nullOnDelete();

            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();

            // Biar kalo parent di delete, thread masih bisa load optimal
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
