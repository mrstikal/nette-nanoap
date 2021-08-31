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
     /** @persistent */
	public $locale;