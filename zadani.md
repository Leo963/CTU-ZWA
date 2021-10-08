# Zadání semestrální práce

- [Zadání semestrální práce](#zadání-semestrální-práce)
  - [Abstrakt](#abstrakt)
  - [Formální zadání](#formální-zadání)
    - [Požadavky](#požadavky-1)
    - [Technická anotace zadání](#technická-anotace-zadání)
      - [Návrh databáze](#návrh-databáze)
      - [Obsáhnuté stránky](#obsáhnuté-stránky)

## Název

Studentská Organizační Platforma

## Abstrakt

Popis zadání jednoduché webu k evidenci studentů a jejich studijních výsledků

## Formální zadání

Klient poptává tvorbu systému jednoduché evidence studentů, předmětů a studijních aspektů spojených s nimi.
Každý student bude moct mít přiřazené předměty a vyučující budou schopni přidávat známky studentům v jejich předmětech.

### Požadavky [^1]

- Musí obsahovat evidenci studentů, vyučujících, předmětů a známek studentů
- Musí podporovat tisk seznamů studentů, tak aby byly seznamy jasně čitelné a uspořádané
- Musí být zabezpečen proti neoprávněným přístupům
- Musí být funkční i při zablokování Java Scriptu
- Musí zvládnout chyby uživatelsky přívětivím způsobem
- Měl by umět filtrovat seznamy dat
- Měl by umět řadit seznamy dat
- Měl by umožnit jednoduché změny vzhledu
- Měl by mít specifický styl pro tisk seznamů pro nejlepčí možnou čitelnost
- Může být založen na databázi či souborech

[^1]: Zpracovány dle [MoSCoW](https://en.wikipedia.org/wiki/MoSCoW_method) metody.

### Technická anotace zadání

Zadání bude realizováno za využití HTML5, CSS a JS pro front end.
Serverová strana bude na platformě PHP.

#### Návrh databáze

![Návrh databáze](https://cdn.discordapp.com/attachments/513038521192153093/892856858279280720/unknown.png)

#### Obsáhnuté stránky

- [x] Přihlašovací stránka - jednoduché přihlášení pomocí
- [ ] Administrace studentů - vyučující a administrátoři vydí seznamy studentů
- [ ] Zápis předmětu - studenti si budou moci zapsat předmět a vybrat si paralelku
- [ ] Postup studenta - souhrnné zobrazení rozvrhu, posledních známek a průměrů
- [ ] Rozvrh - zobrazení rozvrhu dle aktuálních paralelek
- [ ] Vytváření/editace uživatele
- [ ] Vytváření/editace předmětu a jeho paralelek
- [x] Registrace studentů
- [ ] Nastavení účtu uživatele
- [x] Úvodní stránka