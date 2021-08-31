<?php

declare(strict_types=1);

namespace App\Modules\User\Presenters;

use App\Presenters\Base\BasePresenter;
use Nette\Application\UI\Form;

class UserPresenter extends BasePresenter
{
    /** @var \App\Modules\User\Components\LoginForm @inject */
    public $loginForm;


    public function __construct(\App\Modules\User\Components\LoginForm $loginForm)
    {
        $this->loginForm = $loginForm;
    }

    /**
     * Handles locale changes vis contribute/translation
     *
     * @param string $locale
     * @return void
     */
    public function handleChangeLocale(string $locale): void
    {
        $this->translatorSessionResolver->setLocale($locale);
        $this->redirect('this');
    }

    /**
     * Creates login form for user role.
     *
     * @return Form
     */
    protected function createComponentLoginForm(): Form
    {
        $form = $this->loginForm->create('user');

        $this->getFlashSession()->remove();

        return $form;
    }

    public function renderLogin(): void
    {

        $this->template->locale = $this->translator->getLocale();
    }
}
