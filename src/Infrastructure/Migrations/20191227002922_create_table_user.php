<?php

use App\Domain\Constants\TableName;
use App\Infrastructure\Persistence\AbstractMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableUser extends AbstractMigration
{
    public function up(): void
    {
        $this->schema->create(TableName::TABLE_NAME_USER, function (Blueprint $table) {
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

    public function down(): void
    {

        $this->schema->drop('user');
    }
}
