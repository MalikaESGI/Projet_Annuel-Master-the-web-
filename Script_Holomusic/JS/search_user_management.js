let displayStart = 0;

function fetchUsers(searchValue = "") {
    fetch('user_management_back.php')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            displaySearchResults(data, searchValue);
        })
        .catch(function (error) {
            console.log('Une erreur s\'est produite:', error);
        });
}

fetchUsers();

let filterUser = document.getElementById('subRUser');
filterUser.addEventListener('click',(event)=>{
    event.preventDefault();
    let searchValue = document.getElementById('suser').value.trim(); 
    fetchUsers(searchValue);
})

document.getElementById('increase').addEventListener('click', function(event) {
    event.preventDefault();
    displayStart += 10;
    let searchValue = document.getElementById('suser').value.trim(); 
    fetchUsers(searchValue);
});

document.getElementById('decrease').addEventListener('click', function(event) {
    event.preventDefault();
    if (displayStart >= 10) {
        displayStart -= 10;
    } else {
        alert("Can't show previous results");
    }
    let searchValue = document.getElementById('suser').value.trim(); 
    fetchUsers(searchValue);
});

function displaySearchResults(users, searchInputValue) {
    let tableBody = document.querySelector('#searchResults');
    tableBody.innerHTML = '';
    let resultCount = 0; 

    for (let i = displayStart; i < users.length && resultCount < 10; i++) {
        let user = users[i];
        let divisions = Object.values(user)
        
        if (!divisions[2].includes(searchInputValue)) {
            continue;
        }

        let row = document.createElement('tr');

        for (let j = 0; j < divisions.length; j++) {
            let Cell = document.createElement('td');

            if (j == divisions.length - 1) {
                console.log(divisions[j]); // log the value
                if (divisions[j] == 1) { // compare with string values
                    Cell.textContent = 'User';
                } else if (divisions[j] == 2) { // compare with string values
                    Cell.textContent = 'Admin';
                } else {
                    Cell.textContent = divisions[j];
                }
            } else {
                Cell.textContent = divisions[j];
            }
            row.appendChild(Cell); // Append Cell to row here
            if (j == divisions.length - 1) {
                Cell = document.createElement('td');
                Cell.innerHTML = '<a class="btn btn-primary btn-sm" href="/admin/modify_user?id=' + divisions[0] + '">Modifier </a> \
                            <a class="btn btn-danger btn-sm" href="/admin/exclude_user?id=' + divisions[0] + '">Supprimer </a>';
                row.appendChild(Cell);
            }
        }
        tableBody.appendChild(row);
        resultCount++;
    }
}
