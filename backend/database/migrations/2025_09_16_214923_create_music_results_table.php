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
        Schema::create('music_results', function (Blueprint $table) {
            $table->id();
        $table->string('uid')->unique(); // شناسه یکتا برای هر درخواست
        $table->integer('cello_score')->default(0); // امتیاز Cello
        $table->integer('harp_score')->default(0);  // امتیاز Harp
        $table->integer('piano_score')->default(0); // امتیاز Piano
        $table->string('result');  // نتیجه نهایی (Solo, Trio, Duo)
        $table->timestamps(); // زمان ایجاد و آپدیت رکورد
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_results');
    }
};
