// Ucitaj sesiju i prilagodi navigaciju
fetch('/project/addons/session_check.php')
  .then(response => response.json())
  .then(data => {
    const loginLink = document.getElementById('loginLink');
    const adminConsole = document.getElementById('konzolaLink');

    // Postavljanje imena
    if (data.status === 'success') {
      loginLink.innerHTML = `${data.ime} ${data.prezime}`;
      loginLink.href = '#';
      loginLink.onclick = () => {
        if (confirm('zelite li se odjaviti?')) {
          window.location.href = '/project/lar/odjava.php';
        }
      };

      // admin komande
      if (data.uloga === 'admin') {
        adminConsole.classList.remove('d-none');
      }

      // mod komande
      if (data.uloga === 'mod') {
        adminConsole.classList.remove('d-none');
      }
    }
  })
  .catch(error => console.error('Greska pri provjeri sesije:', error));
