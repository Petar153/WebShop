 // Primjena filtera
 function primijeniFiltere() {
    const filterProizvodac = document.getElementById('filterProizvodac').value;
    const filterCijena = document.getElementById('filterCijena').value;

    let filtriraniProizvodi = [...proizvodi]; // Kopiraj sve proizvode iz ucitaj_proizvode.js

    // Filtriraj po proizvodacu
    if (filterProizvodac) {
      filtriraniProizvodi = filtriraniProizvodi.filter(p => p.proizvodac === filterProizvodac);
    }

    // Filtriraj po cijeni
    if (filterCijena) {
      const [min, max] = filterCijena.split('-').map(Number);
      filtriraniProizvodi = filtriraniProizvodi.filter(p => p.cijena >= min && p.cijena <= max);
    }

    
    prikaziProizvode(filtriraniProizvodi); // nalazi se u ucitaj_proizvode.js
  }


  document.getElementById('applyFilters').addEventListener('click', primijeniFiltere);
  ucitajProizvode(); 
