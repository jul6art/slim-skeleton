<?php

Namespace App\Domain\User;

use App\Domain\Constants\TableName;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Infrastructure\Model
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $table = TableName::TABLE_NAME_USER;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return $this;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = trim($firstName);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName($lastName): self
    {
        $this->lastName = trim($lastName);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email): self
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return "$this->firstName $this->lastName";
    }
}