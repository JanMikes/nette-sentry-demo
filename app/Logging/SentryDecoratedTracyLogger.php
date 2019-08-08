<?php declare (strict_types=1);

namespace App\Logging;

use Sentry\Severity;
use Tracy\Debugger;
use Tracy\ILogger;
use function Sentry\captureEvent;

final class SentryDecoratedTracyLogger implements ILogger
{
	/**
	 * @var ILogger
	 */
	private $parentLogger;


	public function __construct(array $sentryOptions)
	{
		$this->parentLogger = Debugger::getLogger();

		\Sentry\init($sentryOptions);
	}


	/**
	 * @param string|\Throwable $value
	 * @param string $priority
	 */
	public function log($value, $priority = self::INFO): void
	{
		// Logging to default Tracy logger
		$this->parentLogger->log($value, $priority);
		$this->logToSentry($value, $priority);
	}


	/**
	 * @param \Throwable|string $value
	 */
	private function logToSentry($value, $priority): void
	{
		$severity = $this->getSeverityFromPriority($priority);

		if (!$severity) {
			return;
		}

		$payload = [
			'message' => $value,
			'level' => $severity,
		];

		if ($value instanceof \Throwable) {
			$payload['exception'] = $value;
			$payload['message'] = $value->getMessage();
		}

		captureEvent($payload);
	}


	private function getSeverityFromPriority(string $priority): ?Severity
	{
		switch ($priority) {
			case ILogger::WARNING:
				return Severity::warning();

			case ILogger::ERROR:
				return Severity::error();

			case ILogger::EXCEPTION:
			case ILogger::CRITICAL:
				return Severity::fatal();

			default:
				return null;
		}
	}
}
