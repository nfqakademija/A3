NFQ AKADEMIJOS 5 GRUPĖS "A3" PROJEKTAS
======
## Komandos nariai:
* Anastasija Andrejeva
* Antanas Gečas
* Andrius Skučas
* Mentorius: Linas Linartas


## Projekte naudojamas GULP kompiliuoti SCSS ir JS failus
### Kaip paleisti kompilerį:
* Parsisiųsti ir instaliuoti node.js - [iš čia](https://nodejs.org/en/download/)
* Atsidaryti terminalą/konsolę projekto puslapyje
* Paleisti komandą - npm install
* Node.js suinstaliuos visus reikiamus packagus
* Norint paleisti automatinį kompiliavimą naudoti komandą - gulp watch

### Gulp'o task'as atlieka
* Watchina app/Resources/js ir app/Resources/scss ir tikrina ar buvo pakeistas failas
* Aptikus pasikeitimą .js faile paleidžiamas taskas 'js' kuris apjungia visus js failus į vieną, gautą failą suminimizina ir sukuria jo mapsą. Sukuriamas naujas failas web/assets/js/app.js
* Aptikus pasikeitimą .scss faile paleidžiami taskai 'sass' ir 'sass-min' kurie apjungia visus .scss failus į vieną, gautą failą suminimizina ir sukuria jo mapsą. Sukuriamas naujas failas web/assets/scss/{pav}.css