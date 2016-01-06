<?php
// TV CMS - fork "onecore" (c) 20015-2016 by Danovich Konstantine Version 1.0.2 Material, Sat Dec 26 19:39 2015 http://comutv.ru/tv
session_start();
ob_start();
?>

<conf>
	<fpp>true</fpp>
	<ftype>html,xhtml</ftype>
	<usr>helion</usr>
	<key>f89c5b5ba5c2883c213415035b9bd911</key>
	<mail>example@mail.com</mail>
</conf>

<?php
$cfgXml = ob_get_contents();
ob_end_clean();
class Conf extends SimpleXMLElement{
	function asXmlWithoutXmlHeader(){
	$xml = $this->asXML();
	$xml = explode("\n", $xml);
	$xml[0] = "";
	$xml = trim( implode($xml, "\n") );	
	return $xml;
	}
}
// Читаем конфиг в xml
$cfg = simplexml_load_string($cfgXml, 'Conf');
if ($cfg == false){echo "Ошибка. Не могу прочесть конфиг файл.";exit;}
ob_start();
#################### ВЕРСТКА
?>

<!doctype html>
<html lang="ru">
	<head>
		<title>TV CMS</title>
		<link rel="stylesheet" href="https://goo.gl/22GCHz">
		<link rel="stylesheet" href="https://goo.gl/Z752Gq">
		<script src="http://goo.gl/KuDUvZ"></script>
		<script src="https://goo.gl/MD1Ikj"></script>
		<script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<style>
		body{background:rgb(97,114,144);}
		.content{position:absolute; top:0; left:0; height:100%; background:white; color:black; overflow-y:auto; overflow-x:hidden;}
		footer{position:absolute; bottom:0; left:0;}
		#vk_groups, #vk_poll,	#vk_groups iframe, #vk_poll iframe{width:100% !important; margin-bottom:10px; margin-top:10px;}
	</style>
	<script type="text/javascript">
		VK.Widgets.Group("vk_groups", {mode: 0, width: "500", height: "200", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 77858018);
		VK.init({apiId: 5214511, onlyWidgets: true});
		VK.Widgets.Poll("vk_poll", {width: "500"}, "208296344_42f4c5328fe8dcad4d");
	</script>
</head> 
<body class="row">
<video class="hide-on-med-and-down" autoplay loop style="position:fixed; right:0; bottom:0; min-width:100%; min-height:100%; width:auto; height:auto; z-index:-100; background:transparent;"><source src="ocean.webm" type="video/webm"></video>
	<div class="hide-on-med-and-down" style="position:fixed; right:0; bottom:0; min-width:100%; min-height:100%; width:auto; height:auto; z-index:-100; background: rgba(97,114,144,.7) url(vover.png);"></div>
		<div class="col s12 m4 content">
			<div class="col s12 m6">
				<img class="col s12 m12" src="tv.jpg" alt="tv cms logotype">
			</div>
			<div class="col s12 m6">
				<h4>TV CMS</h4>
				<h6>Однофайловая CMS для Landing Page</h6>
				<ul>
					<li><i class="material-icons">done</i> Простая</li>
					<li><i class="material-icons">done</i> Неприхотливая</li>
					<li><i class="material-icons">done</i> Быстрая</li>
				</ul>
				<div class="buttons">
					<a href="tv.zip" class="btn light-blue darken-4">Скачать</a>
					<a href="http://github.com/" class="btn light-blue darken-4">GitHub</a>
				</div>
			</div>
			<div class="col s12 m6" id="vk_groups"></div>
			<div class="col s12 m6" id="vk_poll"></div>
			<footer class="col s12 m12 center hide-on-med-and-down">&copy; 2015 - <?=date(Y);?> TV CMS & <a href="https://vk.com/expany" target="_blank">Озорняш</a></footer>
		</div>
</body>
</html>

<?php
#################### КОНЕЦ
$html = ob_get_contents();
ob_end_clean();
// Читаем текущую страницу
$filename = explode("/", $_SERVER['PHP_SELF']);
$filename = $filename[ count($filename) - 1 ];
$pagebuffer = file($filename);
// Дополнительные настройки
$elem = array(
	'ok' => '<input class="btn green" type="submit" value="Ок">',
	'done' => '<a class="btn green" href="#done" onclick="document.getElementById(\'tv\').submit(); return false;"><i class="medium material-icons">done</i></a>',
	'cancel' => '<a class="btn deep-orange accent-4" href="#no" onClick="history.back()"><i class="medium material-icons">not_interested</i></a>',
	'enter' => '<a class="btn green" href="'.$filename.'?admin">Вход</a>',
	'tryagain' => '<a class="btn deep-orange accent-4" href="'.$filename.'?login">Повторить</a>',
	'bg' => '<video autoplay loop style="position:fixed; right:0; bottom:0; min-width:100%; min-height:100%; width:auto; height:auto; z-index:-100; background:transparent;"><source src="ocean.webm" type="video/webm"></video><div style="position:fixed; right:0; bottom:0; min-width:100%; min-height:100%; width:auto; height:auto; z-index:-100; background: rgba(97,114,144,.7) url(vover.png);"></div>',
	'head' => '<title>TV CMS</title><link rel="stylesheet" href="https://goo.gl/22GCHz"><link href="https://goo.gl/Z752Gq" rel="stylesheet"><script src="http://goo.gl/KuDUvZ"></script><script src="https://goo.gl/MD1Ikj"></script><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /></head>'
);
// Получаем секцию A
$i = 0;
for ($i = 0; $i < count($pagebuffer); $i++){
	if ($pagebuffer[$i] != "?>\n"){$phpSectionA .= $pagebuffer[$i];}
	else{$phpSectionA .= "?>\n";break;}
}
// Получаем секцию B
$read = false;
for ($i = $i+1; $i < count($pagebuffer); $i++){
	if ($pagebuffer[$i] == "<?php\n")$read = true;
	if ($pagebuffer[$i] != "?>\n"){if ($read)$phpSectionB .= $pagebuffer[$i];}
	else{$phpSectionB .= "?>\n";break;}
}
// Получаем секцию C
for ($i = (count($pagebuffer)-1); $i >= 0; $i--){
	if ($pagebuffer[$i] != "<?php\n"){$phpSectionC = $pagebuffer[$i] . $phpSectionC;}
	else{$phpSectionC = "<?php\n" . $phpSectionC;break;}
}
// Проверяем разрешения
if ((isset($_GET['admin']) || isset($_GET['edit']) || isset($_GET['conf']) || isset($_GET['import']) || isset($_GET['export'])) && $cfg->fpp == "true" &! $_SESSION['ok'] == true){header("Location: index.php?login");exit;}
#################### LOGIN
if (isset($_GET['login'])){if (!isset($_GET['do'])){echo '
	'.$elem[head].'
	<body>
	'.$elem[bg].'
		<div class="row section auth">
			<div class="col m4">&nbsp;</div>
				<div class="col s12 m4">
					<h5 class="white-text">Авторизация: '.$filename.'</h5>
					<form action="' . $filename . '?login&do" method="POST" />
						<label for="usr">Логин</label>
						<input type="text" name="usr" id="usr" />
						<label for="key">Пароль</label>
						<input type="password" name="key" id="key" />
						'.$elem[ok].'&nbsp;'.$elem[cancel].'
					</form>
				</div>
			</div>';
}
else{if ($_POST['usr'] == $cfg->usr && md5($_POST['key']) == $cfg->key){
	$_SESSION['ok'] = true;
	header("Location: index.php?edit");
}
	else{echo '
		<div class="row section auth">
			<div class="col m4">&nbsp;</div>
				<div class="col s12 m4 center">
					<h5>Что-то пошло не так!</h5>
					<p>'.$elem[tryagain].'</p>
				</div>
			</div>';
		}
	}
}
#################### EDIT
if (isset($_GET['edit'])){
	$page = $html;
	$replacer = str_replace("<", "&lt;", $page);
	echo '
	<title>TV CMS</title>
	<link rel="stylesheet" href="https://goo.gl/22GCHz">
	<link href="https://goo.gl/Z752Gq" rel="stylesheet">
	<script src="http://goo.gl/KuDUvZ"></script>
	<script src="https://goo.gl/MD1Ikj"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<style>
		body{position:absolute; width:100%; height:100%;background:#262626; color:white; overflow-y:hidden;}
		.action{background:#66abb8;}
		.btn-fix{height:2.4rem !important; line-height:2.4rem !important;}
		.btn-pos{display:block; position:absolute; top:20px; right:20px;}
		.tool{background:#8e53b5;}
		#maker{position:absolute; top:0; left:0; width:100%; height:100%; margin-bottom:10px;}
		#page{visibility:hidden;}
		.modal-footer, .modal-fixed-footer, .modal{background:#141414 !important;}
		.modal-footer{border-top:1px solid rgba(0,0,0,0.5) !important;}
	</style>
	</head>
	<body class="blue-grey darken-4">
		<div class="controller">
			<form action="'.$filename.'?save" method="POST" id="tv" />
				<div id="maker" name="html">'.$replacer.'</div>
				<textarea id="page" name="html"></textarea>
				<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js" type="text/javascript" charset="utf-8"></script>
				<script>
					var textarea = $(\'#page\');
					var editor = ace.edit("maker");
					editor.getSession().setUseWorker(false);
					editor.setTheme("ace/theme/chaos");
					editor.getSession().setMode("ace/mode/html");
					editor.getSession().setUseWrapMode(true);
					editor.setShowPrintMargin(false);
					editor.getSession().on(\'change\', function () {textarea.val(editor.getSession().getValue());});
					textarea.val(editor.getSession().getValue());
					editor.commands.addCommand({name: \'SaveCommand\',bindKey: {win: \'Ctrl-M\', mac: \'Command-M\'},exec: function(editor) {document.getElementById(\'tv\').submit();return false;},readOnly: false});
					$(document).ready(function(){$(\'.modal-trigger\').leanModal();});
					$(document).ready(function(){$(\'.tool\').tooltip({delay: 50});});
				</script>
				<center class="btn-pos">
					'.$elem[done].'&nbsp;'.$elem[cancel].'
						<a class="btn tool hide-on-med-and-down" href="index.php?export" data-position="bottom" data-delay="50" data-tooltip="Экспорт верстки"><i class="small material-icons">system_update_alt</i></a>
						<a class="btn tool modal-trigger hide-on-med-and-down" href="#modal" rel="?import" data-toggle="modal" data-target="#modal" rel="index.php?import" data-position="bottom" data-delay="50" data-tooltip="Импорт верстки"><i class="small material-icons">present_to_all</i></a>
						<a class="btn tool modal-trigger hide-on-med-and-down" href="#modal" rel="?conf" data-toggle="modal" data-target="#modal" data-position="bottom" data-delay="50" data-tooltip="Настройки"><i class="small material-icons">settings</i></a>
						<a class="btn tool hide-on-med-and-down" href="'.$filename.'" target="_blank" data-position="bottom" data-delay="50" data-tooltip="Открыть сайт"><i class="small material-icons">replay</i></a>';
	if ($cfg->fpp == 'true'){echo '<a class="btn tool hide-on-med-and-down" href="'.$filename.'?logout" data-position="bottom" data-delay="50" data-tooltip="Выйти"><i class="small material-icons">input</i></a>';}
	echo'
				</center>
			</form>
		</div>
		<div id="modal" class="modal modal-fixed-footer">
			<div class="modal-content">FUCK</div>
			<div class="modal-footer"><a href="#!" class="btn deep-orange accent-4 modal-action modal-close"><i class="material-icons">not_interested</i></a></div>
		</div>
		<script>
			$(\'a.modal-trigger\').on(\'click\', function(e) {
				e.preventDefault();
				var url = $(this).attr(\'rel\');
				$(".modal-content").load(url);
				url=\'\';
			});
		</script>';
}
#################### CONFIG
if (isset($_GET['conf'])){
	if (!isset($_GET['sav'])){echo '
		<form action="' . $filename . '?conf&sav" method="POST" />
			<label for="keyprotection">Требовать авторизацию</label>
			<div class="switch"><label>Нет'; $checked = ($cfg->fpp == 'true') ? 'checked' : ''; echo '<input type="checkbox" name="keyprotection" id="keyprotection" ' . $checked . '/><span class="lever"></span>Да</label></div><br>
			<div class=input-field"><label for="usr">Логин</label><input type="text" name="usr" id="usr" value="'.$cfg->usr.'" /></div>
			<div class=input-field"><label for="key">Пароль(только новый)</label><input type="password" name="key" id="key" /></div>
			<div class=input-field"><label for="mail">Адрес почты</label><input type="text" name="mail" id="mail" /></div>
			<div class=input-field"><label for"allext">Расширения файлов для импорта. Например: \'html,xhtml\'</label><input type="text" name="allext" id="allext" value="'.$cfg->ftype.'" /></div>
			'.$elem[ok].'&nbsp;'.$elem[cancel].'
		</form>';
	}
	else{
		if (isset($_POST['keyprotection'])){$cfg->fpp = 'true';}
		else{$cfg->fpp = 'false';}
		$cfg->usr = $_POST['usr'];
		if (isset($_POST['key']) && $_POST['key'] != ""){$cfg->key = md5($_POST['key']);}
		$cfg->ftype = $_POST['allext'];
		if (!file_put_contents($filename, trim($phpSectionA . "\n" . $cfg->asXmlWithoutXmlHeader() . "\n" . $phpSectionB . "\n" . stripslashes($html) . "\n" . $phpSectionC))){echo '<b>Ошибка. Не могу сохранить настройки.</b>';}
		else{$html = $_POST['html'];header("Location: index.php?admin");}
	}
}
#################### SAVE
if (isset($_GET['save'])){
	if (!file_put_contents($filename, rtrim($phpSectionA . "\n" . $cfgXml . "\n" . $phpSectionB . "\n" . stripslashes($_POST['html']) . "\n" . $phpSectionC))){echo '<b>Ошибка. Не могу сохранить страницу.</b>';}
	else{$html = $_POST['html'];header("Location: index.php?edit");}
}
#################### EXPORT
if (isset($_GET['export'])){
	$exportFilename = explode(".", $filename);
	$exportFilename = $exportFilename[0] . ".html";
	header('Content-type: text/html');
	header('Content-Disposition: attachment; filename="'.$exportFilename.'"');
}
#################### EXIT
if (isset($_GET['logout'])){$_SESSION['ok'] = false;}
#################### IMPORT
if (isset($_GET['import'])){if (!isset($_GET['do'])){echo '
		<h4 class="devider">Импорт HTML верстки</h4>
			<form enctype="multipart/form-data" action="' . $filename . '?import&do" method="POST" id="im">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000">
					<div class="file-field input-field">
						<div class="btn tool">
							<span>Выбрать</span>
							<input type="file">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				<a class="btn green" href="#done" onclick="document.getElementById(\'im\').submit(); return false;"><i class="medium material-icons">play_for_work</i></a>&nbsp;'.$elem[cancel].'
			</form>';
	}
	else{
		$extension = explode(".", $_FILES['userfile']['name']);
		$extension = $extension[1];
		$allext = explode(",", $cfg->ftype);
		if (!in_array($extension, $allext)){echo '<b>Ошибка:</b> Расширение файла \''.$extension.'\' не поддерживается.<br>Пожалуйста, импортируй только файлы указанных форматов:<ul>';
			foreach ($allext as $ext){echo "<li>.$ext</li>";}	
				echo '</ul>
					<a class="btn deep-orange accent-4" href="'.$filename.'?import">Повторить</a>.';
		}
		else{
			$html = implode( file($_FILES['userfile']['tmp_name']) , "" );
			if (!file_put_contents($filename, trim($phpSectionA . "\n" . $cfgXml . "\n" . $phpSectionB . "\n" . stripslashes($html) . "\n" . $phpSectionC))){echo '<p><b>Ошибка: Не могу загрузить файл.</b> <a class="btn deep-orange accent-4" href="'.$filename.'">назад</a>.</p>';}
			else{echo '<p><b>Файл загружен.</b></p><p> <a class="btn teal" href="'.$filename.'">продолжим</a>.</p>';$html = $_POST['html'];}
		}
	}
}
#################### ADMIN
if (isset($_GET['admin'])){$s = $_SESSION['ok'];
	if($s == 1){header("Location: index.php?edit");}
	else{header("Location: index.php?login");}
}
#################### MAILER
if (isset($_GET['mail'])){
	$em = $_POST['em'];
	$msg = $_POST['msg'];
	mail("leaguehelion@gmail.com", "tv cms", $msg, "<hr>Электро почта:", $em);
	header('Location: index.php');
}
if (!isset($_GET['save']) &! isset($_GET['edit']) &! isset($_GET['import']) &! isset($_GET['admin']) &! isset($_GET['login']) &! isset($_GET['conf']) &! isset($_GET['mail']))echo stripslashes($html);
?>
	</body>
</html>
