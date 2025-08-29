<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(22, "mci_Remoto", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(2, "mi_dbo_articulo", $Language->MenuPhrase("2", "MenuText"), "dbo_articulolist.php", 22, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}dbo_articulo'), FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_dbo_cliente", $Language->MenuPhrase("3", "MenuText"), "dbo_clientelist.php", 22, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}dbo_cliente'), FALSE, FALSE);
$RootMenu->AddMenuItem(44, "mci_Trama", $Language->MenuPhrase("44", "MenuText"), "", -1, "", IsLoggedIn(), TRUE, TRUE);
$RootMenu->AddMenuItem(71, "mi_trama_descargas", $Language->MenuPhrase("71", "MenuText"), "trama_descargaslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_descargas'), FALSE, FALSE);
$RootMenu->AddMenuItem(64, "mi_trama_emails", $Language->MenuPhrase("64", "MenuText"), "trama_emailslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_emails'), FALSE, FALSE);
$RootMenu->AddMenuItem(75, "mi_trama_favoritos", $Language->MenuPhrase("75", "MenuText"), "trama_favoritoslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_favoritos'), FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mi_walger_ofertas", $Language->MenuPhrase("19", "MenuText"), "walger_ofertaslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}walger_ofertas'), FALSE, FALSE);
$RootMenu->AddMenuItem(74, "mi_trama_newsletter", $Language->MenuPhrase("74", "MenuText"), "trama_newsletterlist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_newsletter'), FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mi_trama_noticias", $Language->MenuPhrase("11", "MenuText"), "trama_noticiaslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_noticias'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mi_walger_articulos", $Language->MenuPhrase("13", "MenuText"), "walger_articuloslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}walger_articulos'), FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mi_walger_pedidos", $Language->MenuPhrase("20", "MenuText"), "walger_pedidoslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}walger_pedidos'), FALSE, FALSE);
$RootMenu->AddMenuItem(72, "mi_trama_portfolio", $Language->MenuPhrase("72", "MenuText"), "trama_portfoliolist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_portfolio'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mi_walger_clientes", $Language->MenuPhrase("14", "MenuText"), "walger_clienteslist.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}walger_clientes'), FALSE, FALSE);
$RootMenu->AddMenuItem(157, "mi_matriz_valores_stock_precio_php", $Language->MenuPhrase("157", "MenuText"), "matriz_valores_stock_precio.php", 44, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}matriz_valores_stock_precio.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(192, "mci_Remoto_Auxiliares", $Language->MenuPhrase("192", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(5, "mi_dbo_ivacondicion", $Language->MenuPhrase("5", "MenuText"), "dbo_ivacondicionlist.php", 192, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}dbo_ivacondicion'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mi_dbo_listaprecios", $Language->MenuPhrase("6", "MenuText"), "dbo_listaprecioslist.php", 192, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}dbo_listaprecios'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mi_dbo_moneda", $Language->MenuPhrase("7", "MenuText"), "dbo_monedalist.php", 192, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}dbo_moneda'), FALSE, FALSE);
$RootMenu->AddMenuItem(212, "mci_Trama_Auxiliares", $Language->MenuPhrase("212", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(156, "mci_Atributos", $Language->MenuPhrase("156", "MenuText"), "", 212, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(113, "mi_trama_atributos", $Language->MenuPhrase("113", "MenuText"), "trama_atributoslist.php", 156, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_atributos'), FALSE, FALSE);
$RootMenu->AddMenuItem(112, "mi_trama_atributos2Dvalores", $Language->MenuPhrase("112", "MenuText"), "trama_atributos2Dvaloreslist.php?cmd=resetall", 156, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_atributos-valores'), FALSE, FALSE);
$RootMenu->AddMenuItem(102, "mi_trama_tipos2Darticulos", $Language->MenuPhrase("102", "MenuText"), "trama_tipos2Darticuloslist.php", 156, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_tipos-articulos'), FALSE, FALSE);
$RootMenu->AddMenuItem(272, "mci_Categorizacif3n", $Language->MenuPhrase("272", "MenuText"), "", 212, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(9, "mi_trama_categorias2Dproductos", $Language->MenuPhrase("9", "MenuText"), "trama_categorias2Dproductoslist.php", 272, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_categorias-productos'), FALSE, FALSE);
$RootMenu->AddMenuItem(103, "mi_trama_lineas2Dproductos", $Language->MenuPhrase("103", "MenuText"), "trama_lineas2Dproductoslist.php", 272, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_lineas-productos'), FALSE, FALSE);
$RootMenu->AddMenuItem(104, "mi_trama_marcas2Dproductos", $Language->MenuPhrase("104", "MenuText"), "trama_marcas2Dproductoslist.php", 272, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_marcas-productos'), FALSE, FALSE);
$RootMenu->AddMenuItem(246, "mci_Checkout", $Language->MenuPhrase("246", "MenuText"), "", 212, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(108, "mi_trama_cuotas2Drecargos", $Language->MenuPhrase("108", "MenuText"), "trama_cuotas2Drecargoslist.php", 246, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_cuotas-recargos'), FALSE, FALSE);
$RootMenu->AddMenuItem(107, "mi_trama_medios2Dentrega", $Language->MenuPhrase("107", "MenuText"), "trama_medios2Dentregalist.php", 246, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_medios-entrega'), FALSE, FALSE);
$RootMenu->AddMenuItem(106, "mi_trama_medios2Dpagos", $Language->MenuPhrase("106", "MenuText"), "trama_medios2Dpagoslist.php", 246, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_medios-pagos'), FALSE, FALSE);
$RootMenu->AddMenuItem(105, "mi_trama_pagos2Dentregas", $Language->MenuPhrase("105", "MenuText"), "trama_pagos2Dentregaslist.php", 246, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_pagos-entregas'), FALSE, FALSE);
$RootMenu->AddMenuItem(101, "mci_Portfolio", $Language->MenuPhrase("101", "MenuText"), "", 212, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(73, "mi_trama_categorias2Dportfolio", $Language->MenuPhrase("73", "MenuText"), "trama_categorias2Dportfoliolist.php", 101, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_categorias-portfolio'), FALSE, FALSE);
$RootMenu->AddMenuItem(275, "mi_trama_slider", $Language->MenuPhrase("275", "MenuText"), "trama_sliderlist.php", 212, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}trama_slider'), FALSE, FALSE);
$RootMenu->AddMenuItem(62, "mci_Sistema", $Language->MenuPhrase("62", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(21, "mi_walger_usuarios", $Language->MenuPhrase("21", "MenuText"), "walger_usuarioslist.php", 62, "", IsLoggedIn() || AllowListMenu('{8B1B047A-723B-431D-9264-98AA1CD60F92}walger_usuarios'), FALSE, FALSE);
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
