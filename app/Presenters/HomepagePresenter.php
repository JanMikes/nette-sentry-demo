<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	protected function startup(): void
	{
		parent::startup();

		throw new \Exception('This is demo');
	}
}
