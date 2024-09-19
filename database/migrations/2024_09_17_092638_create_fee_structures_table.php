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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_class_id')->constrained('academic_classes')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_head_id')->constrained('fee_heads')->onDelete('cascade');
            $table->string('january')->nullable();
            $table->string('february')->nullable();
            $table->string('march')->nullable();
            $table->string('april')->nullable();
            $table->string('may')->nullable();
            $table->string('june')->nullable();
            $table->string('july')->nullable();
            $table->string('august')->nullable();
            $table->string('september')->nullable();
            $table->string('october')->nullable();
            $table->string('november')->nullable();
            $table->string('december')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};

// constrained() মেথডের প্যারামিটার

// আপনি constrained() মেথডের ভিতরে একটি টেবিলের নাম দিতে পারেন, যেমন: 

// constrained('academic_classes')। এতে Laravel বুঝবে যে আপনি এই কলামটি কোন টেবিলের সাথে লিঙ্ক করতে চান।

// যদি প্যারামিটার না দেন, তাহলে Laravel অনুমান করবে যে foreign key কলামের নামের প্রথম অংশ (যেমন: academic_class) এবং তার সাথে _id যোগ করা হচ্ছে টেবিলের নাম।