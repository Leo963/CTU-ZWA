# Dokumentace semestrální práce

## Zadání semestrální práce

### Název

Studentská Organizační Platforma

### Abstrakt

Popis zadání jednoduché webu k evidenci studentů a jejich studijních výsledků

### Formální zadání

Klient poptává tvorbu systému jednoduché evidence studentů, předmětů a studijních aspektů spojených s nimi.
Každý student si bude moct zapsat paralelky jednotlivých předmětů.

#### Požadavky

- Musí obsahovat evidenci studentů, vyučujících, předmětů
- Musí podporovat tisk seznamů studentů, tak aby byly seznamy jasně čitelné a uspořádané
- Musí být zabezpečen proti neoprávněným přístupům
- Musí být funkční i při zablokování Java Scriptu
- Musí zvládnout chyby uživatelsky přívětivím způsobem
- Měl by umět filtrovat seznamy dat
- Měl by umět řadit seznamy dat
- Měl by mít specifický styl pro tisk seznamů pro nejlepčí možnou čitelnost
- Může být založen na databázi či souborech
- Nebude mít správu známek
- Nebude poskytovat zobrazení předmětů jako rozvrh

Zpracovány dle [MoSCoW](https://en.wikipedia.org/wiki/MoSCoW_method) metody.

#### Technická anotace zadání

Zadání bude realizováno za využití HTML5, CSS a JS pro front end.
Serverová strana bude na platformě PHP.

##### Návrh databáze

![Návrh databáze](https://cdn.discordapp.com/attachments/513038521192153093/929670770005803088/drawSQL-export-2022-01-09_10_39.png)

##### Obsáhnuté stránky

- [x] Přihlašovací stránka - jednoduché přihlášení pomocí
- [x] Administrace studentů - vyučující a administrátoři vydí seznamy studentů
- [x] Zápis předmětu - studenti si budou moci zapsat předmět a vybrat si paralelku
- [x] Postup studenta - souhrnné zobrazení rozvrhu, posledních známek a průměrů
- [x] Vytváření/editace uživatele
- [x] Vytváření/editace předmětu a jeho paralelek
- [x] Registrace studentů
- [x] Nastavení účtu uživatele
- [x] Úvodní stránka

[Wirefame design](https://assets.adobe.com/link/86f37f29-7890-48ed-696e-0a9a9de0af70)

## Manuál webu

Web umožňuju registraci a přihlašování uživatelů.

Uživatelé mají 4 možné role, které mohou mít:

| Role | Práva |
| --- | --- |
| Administrátor | Má práva modifikovat všechny uživatele, předměty a paralelky |
| Učitel | Má práva modifikovat studenty, předměty a paralelky |
| Student | Má práva si zapisovat paralelky |
| Nový uživatel | Má práva si zapisovat paralelky |

Hlavní důvod pro rozdělení Student a Nový uživatel je příprava na budoucnost.

## Technická implementace

Je částečně využita architektura MVC, z níž je stvořen model, byl využit pro oddělení
databázové komunikace od samostných stránek.

Obsluha formulářů je ve většině případů prováděna formulářem samotným, ale jsou pro specifické případy
využity i speciální stránky pro obsloužení požadavků.

U registrace je provedena validace pomocí HTML5, JS a PHP.
Pro kontrolu splnění požadavků je často stanoven regulérní výraz, určující správný formát.

Heslo je podmíněno tímto regulérním výrazem
`^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#$%^&*()=+\-_\[\]\{\};:'\x22\\|,<.>/?€]).{8,}$`
. Tento výraz stanovuje, že je vyžadována číslice, malé a velké písmeno a speciální znak z této sady
`!@#$%^&*()=+\-_\[\]\{\};:'\x22\\|,<.>/?€` a celkový počet znaků musí být alespoň 8.

Hesla jsou ukládány do databáze v podobě BCRYPT hashe s cost indexem 10, tudíž jsou i osolená neb to je 
běžnou součástí BCRYPT algoritmu.

Webový server využit pro toto řešení je Apache s PHP verze 7.4.27.

Databáze je MariaDB 10.3.32.

Databáze byla realizována jako relační a byli využity funkcionality cizích klíčů 
a triggerů pro automazivání chování databáze.

Na serveru jsou zprovozněny obě služby jako Docker kontejnery.

Komunikace mezi PHP a MariaDB je provedena pomocí PDO. Důsledně bylo využíváno prepared statements 
a předávání polí parametrů, tak aby bylo zabráněno SQL Injection.

Na straně webu byli všechny pole jež mohli být ovlivněny XSS ochráněny pomocí `htmlspecialchars`.

Pro udržení konzistetního stylu kódu, byla nastavena pravidla code inspection v PHPStorm, tak aby vymáhali PHP doc 
a další podmínky, aby byl udržen celistvý styl.

Pro JS bylo využito ESLint pro udržení stylu.

Všechny stránky byli validovány pomocí [HTML Validátoru](https://validator.w3.org/).

Pro administrační stránku předmětů, byl vytvořen styl pro tisk.
