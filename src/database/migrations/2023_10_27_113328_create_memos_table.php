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
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //商品の画像のカラム（４枚）
            $table->foreignId('image1')
                ->nullable()
                ->constrained(table: 'images');
            $table->foreignId('image2')
                ->nullable()
                ->constrained(table: 'images');
            $table->foreignId('image3')
                ->nullable()
                ->constrained(table: 'images');
            $table->foreignId('image4')
                ->nullable()
                ->constrained(table: 'images');
            //ソフトデリート
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
