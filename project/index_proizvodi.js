let exchangeRates = {}; 
let defaultCurrency = "EUR"; 

// Funkcija za dohvacanje tecajeva
function ucitajTecajeve() {
  const apiUrl = "https://api.exchangerate-api.com/v4/latest/EUR"; 

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      exchangeRates = data.rates; // Spremi tecajeve
      console.log("Tecajevi ucitani:", exchangeRates);
    })
    .catch(error => console.error("Greska pri dohvacanju tecajeva:", error));
}
 
// Funkcija za prikaz proizvoda
function prikaziProizvode(listaProizvoda) {
  const proizvodiContainer = document.getElementById('proizvodiContainer');
  proizvodiContainer.innerHTML = ''; 

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
  defaultCurrency = selectedCurrency; 
  
  ucitajTipkovnice();
}

// Dohvati po jedan proizvod za svaki proizvodac
function ucitajTipkovnice() {
  fetch('/project/index_proizvodi.php')
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        prikaziProizvode(data.data); 
      } else {
        console.error('Greska pri dohvacanju podataka:', data.message);
      }
    })
    .catch(error => console.error('Greska pri dohvacanju proizvoda:', error));
}




ucitajTecajeve(); 
ucitajTipkovnice(); 
