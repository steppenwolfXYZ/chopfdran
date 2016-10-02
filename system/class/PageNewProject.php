<?php
class PageNewProject extends Page {
		
	protected function init() {
		
		$this->content = '<form action="/'.BASIC_URI.'start" method="post">
		<p>Damit ein Projekt existiert muss man es eben leider auch erfassen!<br />aber juhu/nicht traurig sein.</p>
		<h2 class="formtitle">Projekt</h2>
		<div class="formline">
			<label for="title" class="normal">Titel</label><input type="text" name="title" class="input" />
			<div class="help-tip"><p>Erfinde einen sch&ouml;nen Namen f&uuml;r dieses Projekt. Dann sind alle gl&uuml;cklich.</p></div>
		</div>
		<div class="formline">
			<label for="city" class="normal">Ort</label><input type="text" name="city" class="input" />
			<div class="help-tip"><p>Sage mir, wo du das tun willst. I weis n&auml;r wo dis hus wohnt</p></div>
		</div>
		<div class="formline textarea"><label for="description" class="normal">Beschreibung</label>
			<textarea name="description" maxlength="1000" class="description"></textarea>
		<div class="help-tip"><p>Beschreibe dein Projekt</p></div><br class="clear" />
			<label class="normal">&nbsp;</label><p><span id="chars">1000</span> Zeichen verbleiben</p>
		</div>
		<div class="formline">
			<label for="instrument[1]" class="normal">Besetzung</label>'.$this->generateInstrumentationSelect('instrument[1]').'
			<div class="help-tip"><p>Hier kannst du alle ben&ouml;tigten Instrumente angeben (dich selbst eingeschlossen). F&uuml;r jede Zeile wird eine Person gesucht.</p></div>
			</div>
		<div id="additionalInstrumentation"><div class="formline dummy"><label for="instrumentationDummy" class="normal"></label>'.$this->generateInstrumentationSelect('instrumentationDummy').'</div></div>
		<div class="formline"><label class="normal">Weitere Instrumente</label><input type="button" value="+" id="add_instrument" class="form_button" /></div>
		<div class="formline"><label class="normal">Ich spiele</label><div id="ownInstrument">Bitte w&auml;hle bei der Besetzung mindestens ein Instrument aus, welches du spielst.</div>
		<div class="help-tip"><p>W&auml;hle das Instrument aus, welches du selbst spielen m&ouml;chtest. Wenn du mehrere Instrumente ausw&auml;hlst, wird f&uuml;r dich automatisch das noch fehlende Instrument ausgew&auml;hlt.</p></div>
		</div>
		<div class="formline">
			<label for="date" class="normal">Datum</label>
			<div class="col-sm-3 bootstrap-workaround" id="datetime">
				<input type="text" class="input" name="datetime" id="datetimepicker" />
			</div>
			<div class="help-tip"><p>Es lebe das Datum! Dann finden die Sachen immer statt.</p></div>
		</div>

		<div class="formline"><label class="normal"><input type="button" value="Abbrechen" class="form_button cancel_button" onclick="javascript:window.location.href = \'/'.BASIC_URI.'start\';" /></label><input type="submit" name="newprofileSubmit" value="Juhu fertig!" class="form_button" /></div>
		<input type="hidden" name="mode" value="project" />
		</form>';
		
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/form.js"></script>';
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/instrumentation.js"></script>';
	}
	
}
?>