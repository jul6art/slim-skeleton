<?php

namespace App\Infrastructure\Migrations;

use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateTableUser
 * @package App\Infrastructure\Migrations
 */
class CreateTableUser extends AbstractMigration
{
    public function up()
    {
        $this->schema->create('user', function (Blueprint $table) {
            // Auto-increment id
            $table->increments('id');
            $table->string('firstName',100);
            $table->string('lastName',100);
            $table->string('email',100)->unique();
            $table->string('password');
            // Required for Eloquent's created_at and updated_at columns
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('user');
    }
}