<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `view_products_category` AS select `p`.`id` AS `id`,`p`.`name` AS `name`,`c`.`name` AS `category_name`,`p`.`price` AS `price`,`p`.`quantity` AS `quantity` from (`shop_quan_ao`.`products` `p` join `shop_quan_ao`.`categories` `c` on(`p`.`category_id` = `c`.`id`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `view_products_category`");
    }
};
