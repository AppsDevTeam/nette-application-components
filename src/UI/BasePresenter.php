<?php

use Nette\Application\UI\Presenter;
use Nette\Localization\Translator;

abstract class BasePresenter extends Presenter
{
	abstract protected function getTranslator(): Translator;

	const DEFAULT_AUTO_CLOSE_DURATION = 3000;

	public array $allowedMethods = ['GET', 'POST', 'HEAD'];

	/**
	 * @throws Exception
	 */
	public function flashMessage($message, string $type = 'info'): stdClass
	{
		throw new Exception('Use one of flashMessageError / flashMessageWarning / flashMessageSuccess / flashMessageInfo method instead.');
	}

	public function flashMessageError(string $message, ?int $autoCloseDuration = null): stdClass
	{
		return $this->flashMessageCommon($message, 'danger', $autoCloseDuration);
	}

	public function flashMessageWarning(string $message, ?int $autoCloseDuration = null): stdClass
	{
		return $this->flashMessageCommon($message, 'warning', $autoCloseDuration);
	}

	public function flashMessageSuccess(string $message, ?int $autoCloseDuration = null): stdClass
	{
		return $this->flashMessageCommon($message, 'success', $autoCloseDuration);
	}

	public function flashMessageInfo(string $message, ?int $autoCloseDuration = null): stdClass
	{
		return $this->flashMessageCommon($message, 'info', $autoCloseDuration);
	}

	/** @internal */
	private function flashMessageCommon(string $message, string $type, ?int $autoCloseDuration = null): stdClass
	{
		$this->redrawControl('flashes');
		$flash = parent::flashMessage($this->getTranslator()->translate($message), $type);
		$flash->closeDuration = $autoCloseDuration ?? self::DEFAULT_AUTO_CLOSE_DURATION;
		return $flash;
	}
}
