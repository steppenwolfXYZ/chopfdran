<?php
class PageNewProfile extends Page {
		
	protected function init() {
		$this->content = '<form action="/'.BASIC_URI.'start" method="post">
		<p>Damit m&uuml;sigm&auml;tscher funktioniert, brauchen wir einige wenige Angaben von dir.<br />F&uuml;lle diese Felder aus, danach kann es gleich losgehen.</p>
		<h2 class="formtitle">Personalien</h2>
		<div class="formline">
			<label for="mail" class="normal">E-Mail</label><input type="email" name="mail" class="input" />
			<div class="help-tip"><p>Deine E-Mail-Adresse verwendest du zum einloggen, ausserdem erh&auml;ltst du von uns nach Wunsch benachrichtigungen. Wir versenden keine unaufgeforderten Werbe-Mails und geben die Adresse auch nicht an Dritte weiter.</p></div>
		</div>
		<div class="formline">
			<label for="name" class="normal">Name</label><input type="text" name="name" class="input" />
			<div class="help-tip"><p>Dies ist dein Benutzername, der anderen Benutzern angezeigt wird. Du kannst deinen korrekten Namen oder eine K&uuml;nstler- oder Spitznamen verwenden.</p></div>
		</div>
		<div class="formline"><label for="title" class="normal">Anrede</label>
			<div class="radio">
			<label class="radio-inline"><input type="radio" name="title" value="f" /> weiblich</label>
			<label class="radio-inline"><input type="radio" name="title" value="m" /> m&auml;nnlich</label>
			</div>
		</div>
		<div class="formline">
			<label for="birthdate" class="normal">Geburtsdatum</label><input type="text" name="birthdate" class="input" />
			<div class="help-tip"><p>Um Vorschl&auml;ge mit anderen Musikern &auml;hnlichen Alters zu bevorzugen, ben&ouml;tigen wir dein Geburtsdatum</p></div>
			</div>
		<div class="formline">
			<label for="city" class="normal">Wohnort</label><input type="text" name="city" class="input" />
			<div class="help-tip"><p>Deinen Wohnort ben&ouml;tigen wir, um dir Vorschl&auml;ge von Musikern in deiner N&auml;he machen zu k&ouml;nnen</p></div>
			</div>
		<br />
		<div class="formline">
			<label for="password" class="normal">Passwort</label><input type="password" name="password" class="input" />
			<div class="help-tip"><p>W&auml;hle dein Passwort, welches du zum Einloggen verwendest</p></div>
			</div>
		<div class="formline"><label for="password_repeat" class="normal">Passwort wiederholen</label><input type="password" name="password_repeat" class="input" /></div>
		
		<h2 class="formtitle">Instrument</h2>
		<div class="formline">
			<label for="instrument" class="normal">Instrument</label><select class="input" name="instrument">
				<option value=""></option>';
		$stmt = $this->db->prepare('select id, name from instrument order by name');
		$stmt->execute();
		while($row = $stmt->fetch()) {
			$this->content .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		$this->content .= '</select><div class="help-tip"><p>W&auml;hle das Instrument aus, welches du beherrschst</p></div>
			</div>

		<div class="formline"><label class="normal"></label><input type="submit" name="newprofileSubmit" value="Juhu fertig!" /></div>
		<input type="hidden" name="mode" value="person" />
		</form>';
		
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/form.js"></script>';
	}
}
?>