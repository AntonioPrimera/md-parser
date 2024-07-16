<?php
namespace AntonioPrimera\CustomMarkdown\NodeParsers;

use AntonioPrimera\CustomMarkdown\Parser;

abstract class NodeParser extends Parser
{
	const USES_TRIMMED_PART = 'usesTrimmedPart';
	
	//--- Config Api --------------------------------------------------------------------------------------------------
	
	/**
	 * Determine whether the processor should use the trimmed text or the raw text
	 */
	public function usesTrimmedPart(): bool
	{
		return $this->getConfig(self::USES_TRIMMED_PART, true);
	}
	
	//--- Abstract methods --------------------------------------------------------------------------------------------
	
	/**
	 * Receives the string part and checks whether the part should be processed by this processor
	 * e.g. '#My Title' should be matched only by the processor responsible with handling titles
	 */
	public abstract function matches(string $part): bool;
}