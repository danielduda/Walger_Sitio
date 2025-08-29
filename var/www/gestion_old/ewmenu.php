<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(7, $Language->MenuPhrase("7", "MenuText"), "remitoslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}remitos'), FALSE);
$RootMenu->AddMenuItem(11, $Language->MenuPhrase("11", "MenuText"), "productoslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}productos'), FALSE);
$RootMenu->AddMenuItem(18, $Language->MenuPhrase("18", "MenuText"), "transporte_internolist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}transporte_interno'), FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "operadoreslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}operadores'), FALSE);
$RootMenu->AddMenuItem(6, $Language->MenuPhrase("6", "MenuText"), "proveedoreslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}proveedores'), FALSE);
$RootMenu->AddMenuItem(10, $Language->MenuPhrase("10", "MenuText"), "usuarioslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}usuarios'), FALSE);
$RootMenu->AddMenuItem(19, $Language->MenuPhrase("19", "MenuText"), "configuracioneslist.php", -1, "", AllowListMenu('{B81C6C2E-1100-4548-836E-685E96F6B551}configuraciones'), FALSE);
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
