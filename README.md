# WebShop

Webshop za tipkovnice.
Postoje 3 uloge (kupac, moderator i admin). Ovisno o ulozi, korisnik ima drugacije ovlasti. Npr Admin moze dodavati nove korisnike i proizvode, moderator moze samo dodavati nove proizvode)

Za pokretanje webstranice koristio sam XAMPP

Jezici korišteni za izradu stranice: HTML, CSS (bootstrap), JS, PHP

# Webshop za tipkovnice

## Opis projekta
Ova web aplikacija predstavlja webshop za tipkovnice izrađen korištenjem sljedećih tehnologija:
- HTML
- CSS (Bootstrap)
- JavaScript
- PHP

Za pokretanje web stranice korišten je XAMPP.

---

## Korisničke uloge
Sustav podržava tri vrste korisnika, od kojih svaka ima različite ovlasti:

- **Kupac**
  - Pregled proizvoda

- **Moderator**
  - Dodavanje novih proizvoda

- **Admin**
  - Dodavanje novih korisnika
  - Dodavanje novih proizvoda

---

## Pokretanje web stranice putem XAMPP-a

### 1. Pokretanje XAMPP-a
1. Otvoriti **XAMPP Control Panel**
2. Pokrenuti sljedeće servise:
   - Apache
   - MySQL

---

### 2. Postavljanje projekta
1. Otići u XAMPP instalacijsku mapu (npr. `C:\xampp`)
2. Otvoriti mapu `htdocs`
3. Kopirati folder **project** u `htdocs`

Struktura treba izgledati ovako:
C:\xampp\htdocs\project


---

### 3. Uvoz baze podataka
1. U web pregledniku otvoriti:
http://localhost/phpmyadmin

2. Kliknuti na **New** (Nova baza)
3. Upisati ime baze: korisnici
4. Kliknuti **Create**
5. Nakon toga:
   - Odabrati bazu **korisnici**
   - Kliknuti na **Import**
   - Odabrati datoteku: project/korisnici.sql
   - Kliknuti **Go**

---

### 4. Pokretanje web stranice
U web pregledniku otvoriti: http://localhost/project/index.html
