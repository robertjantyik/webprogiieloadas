# Nethely telepítés FTP-vel és phpMyAdminnal

Ez az eljárás nem igényel parancssori hozzáférést a szerverhez. A Composer-műveletek a saját gépen futnak, a fájlokat FTP/SFTP-n lehet feltölteni, az adatbázist pedig phpMyAdminon keresztül lehet importálni.

## 1. Tárhely és adatbázis létrehozása

1. Hozd létre a Nethely tárhelyet, és csatold hozzá a domaint/aldomaint.
2. A webcím PHP-verzióját állítsd PHP 8.3-ra vagy 8.4-re. A projekt PHP `^8.3` verziót igényel.
3. A webcím könyvtáraként a projekt `public` mappáját kell kiválasztani. A Laravel teljes projektgyökere ne legyen nyilvános webgyökér.
4. Hozz létre egy új, üres MySQL adatbázist. A Nethely adatbázis-útmutatója szerint a felhasználónév megegyezik az adatbázis nevével. Őrizd meg az adatbázis nevét és jelszavát.
5. A Nethely ügyfélfelületén nyisd meg az adatbázishoz tartozó phpMyAdmin kezelőt.

## 2. Függőségek előkészítése a saját gépen

A projekt mappájában, PHP 8.3 vagy újabb verzióval és Composerrel frissítsd a függőségeket, mert a `composer.json` korábban megváltozott:

```sh
composer update
composer install --no-dev --optimize-autoloader
```

A `composer.lock` fájlt is tartsd meg és töltsd fel. A `vendor` könyvtárat FTP-n fel kell tölteni, mert nem szerveren futtatjuk a Composert. A `node_modules`, `.git`, `.idea`, helyi `.env` és helyi SQLite-adatbázis nem kell az éles feltöltéshez.

## 3. Környezeti fájl előkészítése

Másold a `.env.nethely.example` fájlt `.env` néven a Laravel projekt gyökerébe, majd töltsd ki a következőket:

- `APP_KEY`: hozz létre egy egyedi kulcsot helyben, vagy állítsd elő a Laravel helyi környezetében. Ne használj üres kulcsot éles oldalon.
- `APP_URL`: az éles webcím (`http://webproghje.nhely.hu`). HTTP használatakor a session cookie nem lehet HTTPS-only: állítsd `SESSION_SECURE_COOKIE=false` értékre.
- `DB_DATABASE` és `DB_USERNAME`: a Nethely által létrehozott adatbázis neve.
- `DB_PASSWORD`: az adatbázis jelszava.
- `DB_HOST`: a Nethely adatbázis-útmutatójában megadott host. Az oktatási leírás `localhost`-ot használ; ha a fiókhoz eltérő hostot mutat a panel, azt kell beírni.

Az `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_DRIVER=file`, `SESSION_SECURE_COOKIE=false`, `CACHE_STORE=file` és `QUEUE_CONNECTION=sync` beállítások maradjanak. Az éles `.env` fájlt ne töltsd fel GitHubra. A `SESSION_SECURE_COOKIE=false` szükséges ahhoz, hogy a böngésző HTTP-n is visszaküldje a Laravel session cookie-t; HTTPS használatakor legyen `true`.

## 4. Adatbázis importálása phpMyAdminban

Az elkészült `database/nethely-import.sql` tartalmazza az alkalmazás szükséges tábláit, a notebook-adatokat, a kapcsolódó processzor- és operációsrendszer-rekordokat, valamint a fejlesztői admin fiókot.

1. Válaszd ki az új, üres adatbázist phpMyAdminban.
2. Nyisd meg az Importálás fület.
3. Válaszd ki a projekt `database/nethely-import.sql` fájlját.
4. UTF-8 kódolással indítsd el az importot.
5. Ellenőrizd, hogy létrejött a `users`, `processors`, `operating_systems`, `notebooks` és `messages` tábla, valamint megjelentek a notebookrekordok.

Az SQL-importot üres adatbázisra készítettük. Ne importáld meglévő, éles adatokat tartalmazó adatbázisba.

Helyi adatváltoztatás után az importfájl újragenerálható:

```sh
python tools/build_nethely_sql.py
```

## 5. FTP/SFTP-feltöltés és könyvtárelrendezés

A projekt gyökere maradjon a webgyökéren kívül. A kívánt elrendezés:

```text
renew-app/                 <- Laravel projektgyökér, nem publikus
    app/
    bootstrap/
    config/
    database/
    public/                 <- ezt állítsd be webcím könyvtáraként
    resources/
    routes/
    storage/
    vendor/
    .env                    <- éles, titkos konfiguráció
    artisan
```

FTP/SFTP klienssel töltsd fel a projektfájlokat a tárhelyre. A webcímet úgy állítsd be, hogy közvetlenül a `renew-app/public` könyvtárra mutasson. Ne másold a teljes projektet úgy a publikus könyvtárba, hogy az `.env`, `vendor` vagy az alkalmazás forrása weben keresztül elérhető legyen.

## 6. Írási jogosultság és ellenőrzés

A Laravelnek írnia kell a `storage` és a `bootstrap/cache` könyvtárba. Ha a tárhely kezelőfelülete engedélyeket mutat, ezek a mappák legyenek írhatók a PHP-folyamat számára. Ehhez FTP kliens fájljogosultság-kezelője használható; SSH nem szükséges.

Ezután böngészőben ellenőrizd:

1. főoldal és Bootstrap navigáció;
2. notebook-katalógus, keresés és lapozás;
3. diagram;
4. regisztráció, bejelentkezés és kijelentkezés;
5. kapcsolatűrlap és adatbázisba mentett üzenet;
6. üzenetlista bejelentkezett felhasználóval;
7. admin CRUD;
8. mobilos elrendezés.

A Bootstrap és Chart.js CDN-ről töltődik be, ezért az oldal stílusaihoz és diagramjához a böngészőnek internetkapcsolatra van szüksége.

## Fejlesztői admin fiók

Az SQL import a következő fejlesztői admin fiókot hozza létre:

- E-mail: `admin@renew.local`
- Jelszó: `admin12345`

Az első éles belépés után cseréld le a jelszót, vagy az adatbázisban módosítsd az admin jelszóhashét egy új, biztonságos jelszóra. Ne hagyd a fejlesztői jelszót nyilvánosan elérhető éles rendszeren.
