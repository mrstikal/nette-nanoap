<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Passwords;


class UserAuthenticator implements Nette\Security\Authenticator
{
    use Nette\SmartObject;

    private const
        TABLE_NAME = 'users',
        COLUMN_ID = 'id',
        COLUMN_NAME = 'user_name',
        COLUMN_PASSWORD_HASH = 'password_hash',
        COLUMN_STATUS = 'status',
        COLUMN_ROLE = 'role';


    private Nette\Database\Explorer $database;

    private Passwords $passwords;


    public function __construct(Nette\Database\Explorer $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }


    /**
     * Performs an authentication.
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(string $username, string $password): Nette\Security\SimpleIdentity
    {
        $row = $this->database->table(self::TABLE_NAME)
            ->where(self::COLUMN_NAME, $username)
            ->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        } elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        } elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update([
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
            ]);
        }

        $arr = $row->toArray();

        if ($arr[self::COLUMN_ROLE] != 'user') {
            throw new Nette\Security\AuthenticationException('Your role isn\'t user.', self::NOT_APPROVED);
        }

        if ($arr[self::COLUMN_STATUS] != 'enabled') {
            throw new Nette\Security\AuthenticationException('Your account has been disabled.', self::NOT_APPROVED);
        }

        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Nette\Security\SimpleIdentity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
    }
}
