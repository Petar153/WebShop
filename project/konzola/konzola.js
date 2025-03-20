
//provjera ovlasti i ucitavanje stranice ovisno o ovlasti
fetch('/project/addons/session_check.php')
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      if (data.uloga === 'admin') {
       
        document.getElementById('adminConsole').classList.remove('d-none');
        document.getElementById('konzolaLink').classList.remove('d-none');
        
        loadUsers();
        loadProducts();
        loadOrders();
        
        
      } else if (data.uloga === 'mod') {
        document.getElementById('modConsole').classList.remove('d-none');
        document.getElementById('konzolaLink').classList.remove('d-none');
        loadProducts();
        
      }
    } else {
      document.getElementById('unauthorized').classList.remove('d-none');
    }

    

  })
  .catch(error => console.error('Greska pri provjeri uloge:', error));



//ucitavanje korisnika
function loadUsers() {
  fetch('/project/konzola/get_users.php')
    .then(response => response.json())
    .then(data => {
      const usersTable = document.getElementById('usersTable');
      usersTable.innerHTML='';

      data.users.forEach(user=> {
        const row=document.createElement('tr');

        row.innerHTML=`
        <tr>
          <td>${user.username}</td>
          <td>${user.ime}</td>
          <td>${user.prezime}</td>
          <td>${user.email}</td>
          <td>${user.uloga}</td>
          <td>
            <button onclick="editUser(${user.id})">Uredi</button>
            <button onclick="deleteUser(${user.id})">Obrisi</button>
          </td>
        </tr>`;

        usersTable.appendChild(row);
      })

      
    });
}
//ucitavanje proiuzvoda
function loadProducts() {
  fetch('/project/konzola/get_products.php')
    .then(response => response.json())
    .then(data => {
      if(data.status==='success'){

        const productsTable = document.getElementsByClassName('productsTable');
        productsTable[0].innerHTML='';
        productsTable[1].innerHTML='';
        data.products.forEach(product => {
          const row = document.createElement('tr');

          row.innerHTML=`
          <tr>
          <td>${product.naziv}</td>
          <td>${product.proizvodac}</td>
          <td>${product.cijena}</td>
          <td>${product.opis}</td>
          <td>
            <button onclick="editProduct(${product.id})">Uredi</button>
            <button onclick="deleteProduct(${product.id})">Obrisi</button>
          </td>
        </tr>
          `;
          
          productsTable[0].appendChild(row);
          const clonedRow = row.cloneNode(true); 
          productsTable[1].appendChild(clonedRow);
          
        }
        )
      }
    });
}





// Funkcija za brisanje korisnika
function deleteUser(userId) {
  if (confirm('Sigurno zelite obrisati ovog korisnika?')) {
    fetch('/project/konzola/deleteUser.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `userId=${userId}`
    })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Korisnik je obrisan.');
          loadUsers(); 
        } else {
          alert('Greska pri brisanju korisnika.');
        }
      })
      .catch(error => {
        console.error('Greska pri brisanju korisnika:', error);
      });
  }
}

// Funkcija za uredivanje korisnika
function editUser(userId) {
  window.location.href = `/project/konzola/editUser.php?id=${userId}`;
}


// Funkcija za brisanje proizvoda
function deleteProduct(productId) {
  if (confirm('Sigurno zelite obrisati ovaj proizvod?')) {
    fetch('/project/konzola/deleteProduct.php', 
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `productId=${productId}`
    })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert('Proizvod je obrisan.');
          loadProducts(); 
        } else {
          alert('Greska pri brisanju proizvoda.');
        }
      })
      .catch(error => {
        console.error('Greska pri brisanju proizvoda:', error);
      });
  }
}

// Funkcija za uredivanje proizvoda
function editProduct(productId) {
  window.location.href = `/project/konzola/editProduct.php?id=${productId}`;
  
}
//ucitavanje narudzbi
function loadOrders(){
  fetch('/project/konzola/get_narudzbe.php')
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                const tableBodyOrders = document.getElementById('narudzbeTable');
                tableBodyOrders.innerHTML = '';
                
                
                data.narudzbe.forEach(item => {
                  const row = document.createElement('tr');
                  

                  row.innerHTML = `
                    <tr>
                  <td>${item.username}</td>
                  <td>${item.datum}</td>
                  <td>${item.status}</td>
                  <td>${item.metoda_dostave}</td>
                  <td>${item.adresa}</td>
                  <td>${item.telefon}</td>
                  <td>${item.ukupna_cijena} EUR</td>
              </tr>
                  `;
                  tableBodyOrders.appendChild(row);
                  

                });
                
              } 
            });
    }







// Ucitaj navigaciju 
fetch("/project/addons/navbar.html")
  .then(response => response.text())
  .then(data => {
    document.getElementById("navbar").innerHTML = data;

    // Aktivni element
    const currentPath = window.location.pathname;
    const links = {
      '/project/index.html': 'homeLink',
      '/project/proizvodaci/logitech.html': 'logitechLink',
      '/project/proizvodaci/corsair.html': 'corsairLink',
      '/project/proizvodaci/razer.html': 'razerLink',
      '/project/shop.html': 'shopLink',
      '/project/konzola/konzola.html': 'konzolaLink',
      '/project/lar/login.html': 'loginLink'
    };
    // Pronadi odgovarajuci link na temelju trenutne putanje
    const activeLinkId = links[currentPath]; 
    document.getElementById(activeLinkId).classList.add('active');
  })
  .catch(error => console.error('Greska pri ucitavanju navigacije:', error));

 

  // Ucitaj sesiju i prilagodi navigaciju
fetch('/project/addons/session_check.php')
.then(response => response.json())
.then(data => {
  const loginLink = document.getElementById('loginLink');
  const adminConsole = document.getElementById('adminConsole');

  // Postavljanje imena
  if (data.status === 'success') {
    loginLink.innerHTML = `${data.ime} ${data.prezime}`;
    loginLink.href = '#';
    loginLink.onclick = () => {
      if (confirm('zelite li se odjaviti?')) {
        window.location.href = '/project/lar/odjava.php';
      }
    };

  }
})
.catch(error => console.error('Greska pri provjeri sesije:', error));


