<?php
//**Precizie**|Microscopul oferă o imagine de 20 de ori mai mare decât cea obținută cu ochiul liber, ceea ce permite medicului stomatolog să identifice și să trateze cu precizie canalele radiculare.\n**Eficiență**|Tratamentul endodontic cu microscop este mai eficient, deoarece medicul stomatolog poate identifica și trata toate canalele radiculare, chiar și pe cele foarte subțiri.\n**Durată**|Endodontia cu microscop reduce riscul de complicații și necesitatea unui tratament de re-tratare, ceea ce prelungește durata de viață a dintelui.

beforeEach(function () {
	$this->parser = \AntonioPrimera\Md\MarkdownFlavors\BasicMarkdownParser::create();
});

it('can parse bold text, italic text, bold-and-italic text, in several occurrences', function () {
	$text = 'This is **bold** text, this is *italic* text, this is ***bold-and-italic*** text, and this is ***bold-and-italic*** text again.';
	$expected = '<p>This is <strong>bold</strong> text, this is <em>italic</em> text, this is <strong><em>bold-and-italic</em></strong> text, and this is <strong><em>bold-and-italic</em></strong> text again.</p>';
	
	expect($this->parser->parse($text))->toBe($expected);
});