<?php
//**Precizie**|Microscopul oferă o imagine de 20 de ori mai mare decât cea obținută cu ochiul liber, ceea ce permite medicului stomatolog să identifice și să trateze cu precizie canalele radiculare.\n**Eficiență**|Tratamentul endodontic cu microscop este mai eficient, deoarece medicul stomatolog poate identifica și trata toate canalele radiculare, chiar și pe cele foarte subțiri.\n**Durată**|Endodontia cu microscop reduce riscul de complicații și necesitatea unui tratament de re-tratare, ceea ce prelungește durata de viață a dintelui.

use AntonioPrimera\Md\InlineParsers\ItalicParser;

beforeEach(function () {
	$this->parser = new ItalicParser();
});

it('can parse a simple bold text', function () {
	$markdown = '*italic text*';
	$html = '<em>italic text</em>';

	expect($this->parser->parse($markdown))->toBe($html);
});

it('can parse several bold texts', function () {
	$markdown = '*italic text* and *another italic text*';
	$html = '<em>italic text</em> and <em>another italic text</em>';

	expect($this->parser->parse($markdown))->toBe($html);
});
