<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Kita gunakan pengecekan agar tidak error jika kolom ternyata sudah ada
            if (!Schema::hasColumn('news', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
            if (!Schema::hasColumn('news', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('news', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('news', 'content')) {
                $table->longText('content')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('news', 'status')) {
                $table->enum('status', ['draft', 'publish'])->default('draft')->after('content');
            }
            if (!Schema::hasColumn('news', 'image')) {
                $table->string('image')->nullable()->after('status');
            }
            if (!Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('pdf_file');
            }
        });
    }

    public function down(): void
    {
        // Untuk rollback jika diperlukan
        Schema::table('news', function (Blueprint $table) {
            $columns = ['slug', 'category_id', 'user_id', 'content', 'status', 'image', 'published_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('news', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};