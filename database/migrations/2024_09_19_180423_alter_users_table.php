<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. php artisan make:migration alter_users_table
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('academic_class_id')->nullable()->constrained('academic_classes')->onDelete('cascade');
            $table->foreignId('academic_year_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('admission_date')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('mobile_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('academic_class_id');
        Schema::dropColumns('academic_year_id');
        Schema::dropColumns('admission_date');
        Schema::dropColumns('father_name');
        Schema::dropColumns('mother_name');
        Schema::dropColumns('dob');
        Schema::dropColumns('mobile_no');
    }
};
