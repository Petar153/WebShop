// Ucitavanje navigacije
fetch("/project/addons/navbar.html")
  .then(response => response.text())
  .then(data => {
    document.getElementById("navbar").innerHTML = data;
    
    // Dodaj aktivnu klasu na trenutni link
    const currentPath = window.location.pathname;
    const links = {
      '/project/index.html': 'homeLink',
      '/project/proizvodaci/logitech.html': 'logitechLink',
      '/project/proizvodaci/corsair.html': 'corsairLink',
      '/project/proizvodaci/razer.html': 'razerLink',
      '/project/shop.html': 'shopLink',
      '/project/popusti.html': 'popustiLink',
      '/project/lar/login.html': 'loginLink',
      '/project/cart/final.html': 'cartModalContainer'
    };
    // Pronadi odgovarajuci link 
    const activeLinkId = links[currentPath]; 
    document.getElementById(activeLinkId).classList.add('active');
    
  })
  .catch(error => console.error('Greska pri ucitavanju navigacije:', error));

  // Ucitaj cart.html u placeholder
  fetch("/project/cart/cart.html")
      .then(response => response.text())
      .then(data => {
        document.getElementById("cartModalContainer").innerHTML = data;
        
      })
      .catch(error => console.error('Greska pri ucitavanju kosarice:', error));

  // Ucitaj footer 
fetch("/project/addons/footer.html")
.then(response => response.text())
.then(data => {
  document.getElementById("footer").innerHTML = data;
})
.catch(error => console.error('Greska pri ucitavanju podnozja:', error));

// Za valute. Ovo se poziva preko promjene valute
function currencyLoader(){
  promijeniValutu(); //Nalazi se u ucitaj_proizvode.js
  loadCart(); // nalazi se u cart.js
  loadCart2(); // nalazi se u final.js
}

