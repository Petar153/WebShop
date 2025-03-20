
  let proizvodi = []; // proizvodi spremljeni lokalno za filtriranje u filter.js

  let exchangeRates = {}; // Globalni objekt za spremanje tecajeva
  let defaultCurrency = "EUR"; // Zadana valuta
  
  // Funkcija za dohvacanje tecajeva
  function ucitajTecajeve() {
    const apiUrl = "https://api.exchangerate-api.com/v4/latest/EUR"; 
  
    fetch(apiUrl)
      .then(response => response.json())
      .then(data => {
        exchangeRates = data.rates; 
        console.log("Tecajevi ucitani:", exchangeRates);
      })
      .catch(error => console.error("Greska pri dohvacanju tecajeva:", error));
  }

  // Dohvati proizvode iz baze
  function ucitajProizvode() {
    fetch('/project/proizvodaci/fetch_proizvodi.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          proizvodi = data.data; 
          prikaziProizvode(proizvodi);
        } else {
          console.error('Greska prilikom dohvacanja podataka:', data.message);
        }
      })
      .catch(error => console.error('Greska pri dohvacanju proizvoda:', error));
  }

  //Razer Proizvodi
  function ucitajRazerProizvode() {
    fetch('/project/proizvodaci/fetch_proizvodi.php?proizvodac=Razer') //preko GET metode saljemo proizvodac
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const proizvodi = data.data;
          prikaziProizvode(proizvodi);
        } else {
          console.error('Greska prilikom dohvacanja podataka:', data.message);
        }
      })
      .catch(error => console.error('Greska pri dohvacanju proizvoda:', error));
  }

  //Corsair Proizvodi
  function ucitajCorsairProizvode() {
    fetch('/project/proizvodaci/fetch_proizvodi.php?proizvodac=Corsair')//preko GET metode saljemo proizvodac
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const proizvodi = data.data;
          prikaziProizvode(proizvodi);
        } else {
          console.error('Greska prilikom dohvacanja podataka:', data.message);
        }
      })
      .catch(error => console.error('Greska pri dohvacanju proizvoda:', error));
  }

  //Logitech Proizvodi
  function ucitajLogitechProizvode() {
    fetch('/project/proizvodaci/fetch_proizvodi.php?proizvodac=Logitech')//preko GET metode saljemo proizvodac
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const proizvodi = data.data;
          prikaziProizvode(proizvodi);
        } else {
          console.error('Greska prilikom dohvacanja podataka:', data.message);
        }
      })
      .catch(error => console.error('Greska pri dohvacanju proizvoda:', error));
  }

  // Prikaz proizvoda
  function prikaziProizvode(listaProizvoda) {
    
    const proizvodiContainer = document.getElementById('proizvodiContainer');
    proizvodiContainer.innerHTML = ''; // Ocisti prethodni sadrzaj
    listaProizvoda.forEach(proizvod => {

      const basePrice = parseFloat(proizvod.cijena); 

    // Preracun cijene u trenutnu valutu
    const convertedPrice = (basePrice * (exchangeRates[defaultCurrency] || 1)).toFixed(2);

      const proizvodCard = `
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="${proizvod.slika}" class="card-img-top" alt="${proizvod.naziv}">
            <div class="card-body">
              <h5 class="card-title">${proizvod.naziv}</h5>
              <p class="card-text">Proizvodac: ${proizvod.proizvodac}</p>
              <p class="card-text">Cijena: ${convertedPrice} ${defaultCurrency}</p>
              <p class="card-text">${proizvod.opis}</p>
              <button class="btn btn-primary" onclick="addToCart(${proizvod.id})">Dodaj u kosaricu</button>
            </div>
          </div>
        </div>
      `;
      proizvodiContainer.innerHTML += proizvodCard;
    });
  }

  // Funkcija za promjenu valute
function promijeniValutu() {
  const selectedCurrency = document.getElementById("currencySelector").value;
  defaultCurrency = selectedCurrency; // Postavi novu zadanu valutu
  
  //Ovisno o trenutnoj stranici, ponovo ucitaj stranicu
  const currentPath=window.location.pathname;
  const logitech = '/project/proizvodaci/logitech.html';
  const corsair =  '/project/proizvodaci/corsair.html';
  const razer = '/project/proizvodaci/razer.html';
  const shop = '/project/shop.html';
  switch (currentPath) {
    case logitech:
      ucitajLogitechProizvode();
      break;
    case corsair:
      ucitajCorsairProizvode();
      break;
    case razer:
      ucitajRazerProizvode();
      break;
    case shop:
      ucitajProizvode();
      break;
    default:
      console.log("Nema path");
  }
  

}
 
ucitajTecajeve(); 