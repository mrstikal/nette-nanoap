<?php

declare(strict_types=1);

namespace App\Modules\User\Components;

use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;
use Nette\Utils\Html;
use App\Forms\FormFactory;
use App\Modules\User\Models\UserState;
use stdClass;

class LoginForm
{
    /** @var \Nette\Localization\ITranslator */
    private $translator;

    /** @var \App\Forms\FormFactory */
    private $factory;

    /** @var \App\Modules\User\Models\UserState */
    private $userState;

    /**
     * User role from form
     *
     * @var string
     */
    private $role;

    public function __construct(ITranslator $translator, FormFactory $factory, UserState $userState)
    {
        $this->translator = $translator;
        $this->factory = $factory;
        $this->userState = $userState;
    }

    /**
     * Creates final form
     *
     * @param string $role
     * @return Form
     */
    public function create(string $role): Form
    {
        $this->role = $role;

        $form = $this->factory->create();

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'table class="form_table"';

        $form->addText('user_name', Html::el('div class="form_icon usr_icon"'))
            ->setHtmlAttribute('placeholder', $this->translator->translate('messages.userName'))
            ->setAttribute('class', 'plain_input user_name_input')
            ->setAttribute('autocomplete', 'one-time-code');

        $form->addPassword('password', Html::el('div class="form_icon pwd_icon"'))
            ->setHtmlAttribute('placeholder', $this->translator->translate('messages.password'))
            ->setAttribute('class', 'plain_input password_input')
            ->setAttribute('autocomplete', 'one-time-code');

        $form->addSubmit('send', $this->translator->translate('messages.submit'))
            ->setAttribute('class', 'submit_form');

        $form->addProtection();

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    /**
     * Check for form success, on error set flashes, 
     * on success redirect to user resume
     *
     * @param Form $form
     * @param \stdClass $values
     * @return void
     */
    public function processForm(Form $form, \stdClass $values): void
    {
        $data = $this->userState->setCurrentUser($values->user_name, $values->password, $this->role);

        if (!empty($data['errors'])) {
            foreach ($data['errors'] as $error) {
                $form->getPresenter()->flashMessage($error, 'form_error');
            }
            $form->getPresenter()->redirect('this');
        } else {
            $form->getPresenter()->redirect('Homepage:resume');
        }
    }
}
