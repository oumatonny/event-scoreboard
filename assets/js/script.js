function fetchScoreboard() {
    fetch('../includes/functions.php?action=get_scoreboard')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('#scoreboard tbody');
            tbody.innerHTML = '';
            
            data.forEach((participant, index) => {
                const row = document.createElement('tr');
                
                if (index === 0) {
                    row.classList.add('first-place');
                } else if (index === 1) {
                    row.classList.add('second-place');
                } else if (index === 2) {
                    row.classList.add('third-place');
                }
                
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${participant.name}</td>
                    <td>${participant.total_points}</td>
                `;
                
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching scoreboard:', error));
}