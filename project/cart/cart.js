// Dohvati kosaricu i prikazuj proizvode
function loadCart() {
 
  

    fetch('/project/cart/get_cart.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          const cartItems = document.getElementById('cartItems');
          cartItems.innerHTML = '';
          let total = 0; // ukupna cijena
          
          data.kosarica.forEach(item => {
            const row = document.createElement('tr');
            let pricee = parseFloat(item.cijena);
            let finalprice = (pricee * (exchangeRates[defaultCurrency] || 1)).toFixed(2);

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
          const convertedPrice = (basePrice * (exchangeRates[defaultCurrency] || 1)).toFixed(2);

          document.getElementById('cartTotal').textContent = `${convertedPrice} ${defaultCurrency}`;
        } 
      });
  }
  
  // Funkcija za dodavanje proizvoda u kosaricu
  function addToCart(proizvod_id) {
    fetch('/project/cart/add_to_cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `proizvod_id=${proizvod_id}&kolicina=1`
      })
    .then(response => response.json())
    .then(data => {

      if (data.status == 'success') {
        alert(data.message);
        loadCart();  
      } else {
        alert(data.message);
      }
    });
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
        
        loadCart();  
      } else {
        alert(data.message);
      }
    });
  }
  
// Funkcija za azuriranje kolicine u kosarici
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
        
        loadCart();  
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
  
// ucita Kosaricu nakon ucitavanja stranice
  document.addEventListener('DOMContentLoaded', loadCart);
  