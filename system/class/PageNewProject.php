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
			<div class="help-tip"><p>Sage mir, wo du das machen willst. I weis n&auml;r wo dis hus wohnt</p></div>
		</div>
		<div class="formline textarea"><label for="description" class="normal">Beschreibung</label>
			<textarea name="description"></textarea>
		</div>
		<div class="formline">
			<label for="instrumentation" class="normal">Besetzung</label><select class="input" name="instrumentation">
				<option value=""></option>';
		$stmt = $this->db->prepare('select id, name from instrument order by name');
		$stmt->execute();
		while($row = $stmt->fetch()) {
			$this->content .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		$this->content .= '</select>
			<div class="help-tip"><p>Das Haus ist besetzt.</p></div>
			</div>
		<div class="formline">
			<label for="date" class="normal">Datum</label><input type="text" name="date" class="input" /><div class="help-tip"><p>Es lebe das Datum! Dann finden die Sachen immer statt.</p></div>
			</div>

		<div class="formline"><label class="normal"></label><input type="submit" name="newprofileSubmit" value="Juhu fertig!" /></div>
		<input type="hidden" name="mode" value="project" />
		</form>';
		
		$this->content .= '<div id="js"></div><script type="text/javascript" src="/'.BASIC_URI.'system/js/form.js"></script>';
	}
}
?>