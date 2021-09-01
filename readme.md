Nette NanoApp
=================

Toto je nano aplikace, která vznikla na základě Vašeho zadání.

__Aplikace byla vytvořená s ohledem na možné budoucí rozšíření nebo změny__

Např. databázová vrstva počítá s tím, že by bylo možné nasadit např. některé ORM.

Oproti zadání jsou zde drobné změny:

__Authentikátory__:

*  byly vytvořeny dle zadání, ale ve finálním řešení nebyly použity (app\Modules\Authenticator)
*  důvodem je univerzálnější řešení uživatelovy autentikace, které ověřuje i platnost polí v db apod.

__Parametr jazykové mutace__:

Vzhledem k použití knihovny contributte/translation nebylo potřeba implementovat persistentní parametr.
Ten by byl jinak implementován ve tvaru
```
    /** @persistent */
	public $locale;
```

## Živá verze projektu:

[https://mrstik.cz/nette-nanoapp//](https://mrstik.cz/nette-nanoapp/)

__Přihlašovací údaje uživatelů a jejich role/stavy__

__alex__
alexheslo
(admin, enabled)

__jindra__
jindraheslo
(user, enabled)

__franta__
frantaheslo
(user, disabled)

__pepa__
pepaheslo
(user, enabled)

__olda__
oldaheslo
(user, disabled)

__jirina__
jirinaheslo
(admin, enabled)

__jana__
janaheslo
(user, enabled)

__stana__
stanaheslo
(user, enabled)

## Databáze:

Vzhledem k existenci jedné tabulky nebyla instalovaná knihovna pro migrace.
Dump db najdete ve složce _data/migrations_.