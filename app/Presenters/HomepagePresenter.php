<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Presenters\Base\BasePresenter;


class HomepagePresenter extends BasePresenter
{
    public function handleChangeLocale(string $locale): void
    {
        $this->translatorSessionResolver->setLocale($locale);
        $this->redirect('this');
    }

    public function actionLogOut()
    {
        $this->getUser()->logout();
        $this->redirect('Homepage:default');
    }

    public function renderDefault(): void
    {
        $this->template->locale = $this->translator->getLocale();
    }

    public function renderResume(): void
    {
        $user = $this->getUser();

        if (!$user->isLoggedIn()) {
            $this->redirect('Homepage:default');
        };

        $this->template->locale = $this->translator->getLocale();
        $this->template->user = $user->getIdentity()->data;
    }
}
