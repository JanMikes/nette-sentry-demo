<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Tracy\Debugger;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	protected function startup(): void
	{
		parent::startup();

		try {
			throw new \Exception('This is demo!');
		} catch (\Exception $e) {
			Debugger::log($e, Debugger::CRITICAL);
		}
	}
}
