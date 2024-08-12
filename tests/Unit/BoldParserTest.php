<?php
//**Precizie**|Microscopul oferă o imagine de 20 de ori mai mare decât cea obținută cu ochiul liber, ceea ce permite medicului stomatolog să identifice și să trateze cu precizie canalele radiculare.\n**Eficiență**|Tratamentul endodontic cu microscop este mai eficient, deoarece medicul stomatolog poate identifica și trata toate canalele radiculare, chiar și pe cele foarte subțiri.\n**Durată**|Endodontia cu microscop reduce riscul de complicații și necesitatea unui tratament de re-tratare, ceea ce prelungește durata de viață a dintelui.

use AntonioPrimera\Md\InlineParsers\BoldParser;

beforeEach(function () {
	$this->parser = new BoldParser();
});

it('can parse a simple bold text', function () {
	$markdown = '**bold text**';
	$html = '<strong>bold text</strong>';

	expect($this->parser->parse($markdown))->toBe($html);
});

it('can parse several bold texts', function () {
	$markdown = '**bold text** and **another bold text**';
	$html = '<strong>bold text</strong> and <strong>another bold text</strong>';

	expect($this->parser->parse($markdown))->toBe($html);
});
