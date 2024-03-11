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
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('handling frozen feeds');

            // handling_live_feedsの後ろに新しいカラムを追加する
            $table->string('handling_frozen_feeds')->after('handling_live_feeds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            // 追加したカラムを削除する
            $table->dropColumn('handling_frozen_feeds');
            // handling_frozen_feedsカラムを再度追加する
            $table->string('handling frozen feeds')->after('handling_live_feeds')->nullable();
            // もしカラムにデフォルト値が必要ならば、->default('デフォルト値')を追加してください
        });
    }
};
