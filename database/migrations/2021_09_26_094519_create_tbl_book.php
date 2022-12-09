<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_book', function (Blueprint $table) {
            $table->Increments('book_id');
            $table->Integer('category_id');
            $table->Integer('author_id');
            $table->string('book_name',100);
            $table->text('book_desc');
            $table->string('book_price');
            $table->string('book_image');
            $table->Integer('book_quantity');
            $table->Integer('book_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_book');
    }
}
