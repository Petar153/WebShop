function loadCart2() {
 
    fetch('/project/cart/get_cart.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const cartItems = document.getElementById('cartItems2');
          cartItems.innerHTML = '';
          let total = 0;
          
          data.kosarica.forEach(item => {
            const row = document.createElement('tr');
            let pricee = parseFloat(item.cijena);
            const finalprice = (pricee * (exchangeRates[defaultCurrency] || 1)).toFixed(2);

            row.innerHTML = `
              <td>${item.naziv}</td>
              <td>
                <button class="btn btn-sm btn-secondary" onclick="decreaseQuantity(${item.id})">-</button>
                ${item.kolicina}
                <button class="btn btn-sm btn-secondary" onclick="increaseQuantity(${item.id})">+</button>
              </td>
              <td>${finalprice} ${defaultCurrency}</td>
              <td>${(finalprice * item.kolicina).toFixed(2)} ${defaultCurrency}</td>
              <td><button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">Ukloni</button></td>
            `;
            cartItems.appendChild(row);
            total += item.cijena * item.kolicina;

          });
          let basePrice = parseFloat(total);
          const convertedPrice2 = (basePrice * (exchangeRates[defaultCurrency] || 1)).toFixed(2);
          document.getElementById('ukupnaCijenaDefault').value = basePrice;
          document.getElementById('cartTotal2').textContent = `${convertedPrice2} ${defaultCurrency}`;
        } 
      });
  }

  function updateQuantity(proizvod_id, akcija) {
    fetch('/project/cart/update_quantity.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `proizvod_id=${proizvod_id}&akcija=${akcija}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        
        loadCart2();  
      } else {
        alert(data.message);
      }
    });
  }
  
  // Funkcija za povecanje kolicine
  function increaseQuantity(proizvod_id) {
    updateQuantity(proizvod_id, 'increase');
  }
  
  // Funkcija za smanjenje kolicine
  function decreaseQuantity(proizvod_id) {
    updateQuantity(proizvod_id, 'decrease');
  }
// Funkcija za uklanjanje proizvoda iz kosarice
function removeFromCart(proizvod_id) {
    fetch('/project/cart/remove_from_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `proizvod_id=${proizvod_id}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        
        loadCart2();  
      } else {
        alert(data.message);
      }
    });
  }

  let exchangeRates = {}; 
  let defaultCurrency = "EUR"; 
  
  // Funkcija za dohvacanje tecajeva
  function ucitajTecajeve() {
    const apiUrl = "https://api.exchangerate-api.com/v4/latest/EUR"; 
  
    fetch(apiUrl)
      .then(response => response.json())
      .then(data => {
        exchangeRates = data.rates; // Spremi tecajeve
        console.log("Tecajevi ucitani:", exchangeRates); //provjera da sprema dobro
      })
      .catch(error => console.error("Greska pri dohvacanju tecajeva:", error));
  }

  function promijeniValutu() {
    const selectedCurrency = document.getElementById("currencySelector").value;
    defaultCurrency = selectedCurrency; // Postavi novu zadanu valutu
    
    
    loadCart2();
  }

  
ucitajTecajeve();
document.addEventListener('DOMContentLoaded', loadCart2());