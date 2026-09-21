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
        $database = env('DB_DATABASE');
        if (empty($database) || app()->environment('testing') || $database === ':memory:') {
            return;
        }

        DB::statement("CREATE VIEW `view_invoice_history` AS select `i`.`id` AS `id`,`i`.`invoice_number` AS `invoice_number`,`u`.`name` AS `customer_name`,`o`.`id` AS `order_id`,`p`.`payment_method` AS `payment_method`,`p`.`payment_status` AS `payment_status`,`p`.`amount` AS `amount`,`i`.`issued_date` AS `issued_date` from (((`$database`.`invoices` `i` join `$database`.`payments` `p` on(`i`.`payment_id` = `p`.`id`)) join `$database`.`orders` `o` on(`p`.`order_id` = `o`.`id`)) join `$database`.`users` `u` on(`o`.`user_id` = `u`.`id`)))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `view_invoice_history`");
    }
};
