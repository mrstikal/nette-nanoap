<?php

declare(strict_types=1);

namespace App\Modules\User\Models;

use App\Modules\Database\Models\DatabaseLayer;
use App\Modules\User\Helpers\ParamValidator;
use Nette\Security\Passwords;
use Nette\Security\Identity;
use Nette\Security\User;
use Nette\Localization\ITranslator;

class UserState
{

    const LOGGED_IN = 'logged in';
    const LOGGED_OUT = 'logged out';

    const TABLE_NAME = 'user';

    const PRIMARY_KEY = 'id';

    const COL_NAME = 'user_name';
    const COL_PASSWORD_HASH = 'password_hash';
    const COL_STATUS = 'status';
    const COL_ROLE = 'role';
    const COL_ID = 'id';

    const TIME_EXPIRE = '10 minutes';

    /** 
     * @var \App\Modules\Database\Models\DatabaseLayer 
     */
    public $database;

    /** 
     * @var \Nette\Security\Passwords 
     */
    public $passwordEngine;

    /** 
     * @var \Nette\Localization\ITranslator 
     */
    private $translator;

    /**
     * Current user
     *
     * @var \Nette\Security\User
     */
    private $user;

    /**
     * Current user identity
     *
     * @var \Nette\Security\Identity
     */
    private $identity;

    /**
     * Usr name
     *
     * @var string
     */
    private $userName;

    /**
     * Usr pwd
     *
     * @var string
     */
    private $password;

    /**
     * Array of user properties
     *
     * @var array
     */
    private $userData;

    /**
     * Is user role validated?
     *
     * @var bool
     */
    private $roleOk;

    /**
     * Is user status validated?
     *
     * @var bool
     */
    private $statusOk;

    /**
     * User role fulfils required one?
     *
     * @var [type]
     */
    private $userRole;

    /**
     * Is user account enabled?
     *
     * @var bool
     */
    private $enabled;

    private $result = [
        'errors' => [],
        'identity' => [],
        'isLogged' => false,
    ];


    /**
     * Instantiates services
     *
     * @param DatabaseLayer $database
     * @param Passwords $passwordEngine
     * @param User $user
     * @param ITranslator $translator
     */
    public function __construct(DatabaseLayer $database, Passwords $passwordEngine, User $user, ITranslator $translator)
    {
        $this->user = $user;
        $this->database = $database;
        $this->passwordEngine = $passwordEngine;
        $this->translator = $translator;
    }

    /**
     * Validates user, logs in on success
     *
     * @param string $userName
     * @param string $password
     * @return mixed void if success, array of errors if something went wrong
     */
    public function setCurrentUser(string $userName, string $password, string $requstedRole)
    {
        //check if usr and pwd
        if (empty($userName) || empty($password)) {
            if (empty($userName)) $this->result['errors'][] = $this->translator->translate('errors.fillUserName');
            if (empty($password)) $this->result['errors'][] = $this->translator->translate('errors.fillPassword');
            return $this->result;
        }

        $this->userName = $userName;
        $this->password = $password;

        //get usr data from db
        $this->setUserData();

        //if usr doesn't exist
        if (empty($this->userData)) {
            $this->result['errors'][] = $this->translator->translate('errors.userNotExists');
            return $this->result;
        }

        //validates user parameter, @see ParamValidator class
        $this->validateUserParams();

        //wrong role
        if (!$this->roleOk) {
            $this->result['errors'][] = $this->translator->translate('errors.undefinedRole');
            return $this->result;
        }

        //wrong status
        if (!$this->statusOk) {
            $this->result['errors'][] = $this->translator->translate('errors.undefinedStatus');
            return $this->result;
        }

        //disabled account
        if (!$this->enabled) {
            $this->result['errors'][] = $this->translator->translate('errors.userDisabled');
            return $this->result;
        }

        if ($this->userData['role'] !== $requstedRole) {
            $this->result['errors'][] = $this->translator->translate('errors.wrongRole', ['role' => $requstedRole]);
            return $this->result;
        }

        //wrong password
        if (!$this->validatePassword()) {
            $this->result['errors'][] = $this->translator->translate('errors.invalidPassword');
            return $this->result;
        }

        //if everything ok, get user identity and login

        $this->getIdentity();

        $this->login();
    }

    /**
     * Loads user from db
     *
     * @return void
     */
    private function setUserData(): void
    {
        $this->userData = $this->database
            ->fetchOneRow(
                self::TABLE_NAME,
                [
                    ['key' => 'user_name', 'value' => $this->userName]
                ]
            );
    }

    /**
     * Validates user params
     * @see ParamValidator class
     *
     * @return void
     */
    private function validateUserParams(): void
    {
        $this->roleOk = ParamValidator::validateRole($this->userData[self::COL_ROLE]);
        $this->statusOk = ParamValidator::validateStatus($this->userData[self::COL_STATUS]);
        $this->enabled = ParamValidator::isEnabled($this->userData[self::COL_STATUS]);
    }

    /**
     * Validates user pwd
     *
     * @return boolean true on success
     */
    private function validatePassword(): bool
    {
        if ($this->passwordEngine->needsRehash($this->userData[self::COL_PASSWORD_HASH])) {

            $newHash = $this->passwordEngine->hash($this->password);

            $this->database
                ->updateOneRow(self::TABLE_NAME, [self::PRIMARY_KEY => $this->userData[self::COL_ID]], [self::COL_PASSWORD_HASH => $newHash]);
        }

        return $this->passwordEngine->verify($this->password, $this->userData[self::COL_PASSWORD_HASH]);
    }

    /**
     * Creates user identity
     *
     * @return void
     */
    private function getIdentity(): void
    {
        unset($this->userData[self::COL_PASSWORD_HASH]);

        $this->identity = new Identity(
            $this->userData[self::COL_ID],
            $this->userData[self::COL_ROLE],
            $this->userData
        );
    }

    /**
     * Logs user in
     *
     * @return void
     */
    private function login(): void
    {
        $this->user->setExpiration(self::TIME_EXPIRE);
        $this->user->login($this->identity);
    }
}
