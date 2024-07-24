const API_URL = 'http://localhost/orizon_travel/api/';

function addCountry() {
    const countryName = document.getElementById('countryName').value;

    fetch(`${API_URL}countries.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: countryName }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert(data.message);
        if (data.status === 'success') {
            document.getElementById('countryName').value = '';
        }
    })
    .catch(error => console.error('Error:', error));
}

function addTrip() {
    const tripCountries = document.getElementById('tripCountries').value;
    const availableSpots = document.getElementById('availableSpots').value;

    fetch(`${API_URL}trips.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ countries: tripCountries, available_spots: availableSpots }),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert(data.message);
        if (data.status === 'success') {
            document.getElementById('tripCountries').value = '';
            document.getElementById('availableSpots').value = '';
        }
    })
    .catch(error => console.error('Error:', error));
}

function filterTrips() {
    const filterCountry = document.getElementById('filterCountry').value;
    const filterSpots = document.getElementById('filterSpots').value;

    let url = `${API_URL}trips.php`;
    if (filterCountry || filterSpots) {
        url += '?';
        if (filterCountry) {
            url += `country=${filterCountry}&`;
        }
        if (filterSpots) {
            url += `spots=${filterSpots}`;
        }
    }

    fetch(url)
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const tripsTable = document.getElementById('tripsTable').getElementsByTagName('tbody')[0];
        tripsTable.innerHTML = '';

        data.forEach(trip => {
            const row = tripsTable.insertRow();
            row.insertCell(0).innerText = trip.id;
            row.insertCell(1).innerText = trip.countries;
            row.insertCell(2).innerText = trip.available_spots;
            const actionsCell = row.insertCell(3);
            actionsCell.innerHTML = `<button onclick="deleteTrip(${trip.id})">Delete</button>`;
        });
    })
    .catch(error => console.error('Error:', error));
}

function deleteTrip(id) {
    fetch(`${API_URL}trips.php?id=${id}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert(data.message);
        filterTrips();
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    filterTrips(); 
});
