<?php

declare(strict_types=1);

namespace App\Presenters\Base;

use Nette\Application\UI\Presenter;
use Nette\Database\Explorer;

abstract class BasePresenter extends Presenter
{
    protected $database;

    /** @var \App\Modules\User\Models\UserState @inject */
    public $userState;

    /** @var \Nette\Localization\ITranslator @inject */
    public $translator;

    /** @var \Contributte\Translation\LocalesResolvers\Router @inject */
    public $translatorSessionResolver;

    /** @persistent */
    public $lang;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    abstract public function handleChangeLocale(string $locale): void;
}
