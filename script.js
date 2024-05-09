// Add a new subject
document.getElementById('subjectForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const subjectName = document.getElementById('subjectName').value;

    fetch('add_subject.php', {
        method: 'POST',
        body: JSON.stringify({ name: subjectName }),
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert(data.message);
                fetchAndDisplaySubjects(); // Refresh the subjects list after adding
            } else {
                alert(data.message);
            }
            document.getElementById('subjectName').value = ''; // Clear the input field
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

// //Fetch and display subjects
// function fetchAndDisplaySubjects() {
//     fetch('fetch_subjects.php')
//     .then(response => response.json())
//     .then(subjects => {
//         const container = document.getElementById('subjectsContainer');
//         container.innerHTML = ''; // Clear current contents

//         subjects.forEach(subject => {
//             const subjectElem = document.createElement('div');
//             subjectElem.classList.add('subject');
//             subjectElem.id = `subject-${subject.id}`;

//             const title = document.createElement('h3');
//             title.textContent = subject.name;

//             const alertsList = document.createElement('ul');
//             subject.alerts.forEach(alertDate => {
//                 const listItem = document.createElement('li');
//                 listItem.textContent = new Date(alertDate).toLocaleString();
//                 alertsList.appendChild(listItem);
//             });

//             // Create Edit button
//             const editButton = document.createElement('button');
//             editButton.textContent = 'Edit';
//             editButton.classList.add('edit-button'); // Use class for delegated event handling
//             editButton.dataset.subjectId = subject.id; // Store subject ID

//             // Create Delete button
//             const deleteButton = document.createElement('button');
//             deleteButton.textContent = 'Delete';
//             deleteButton.classList.add('delete-button'); // Use class for delegated event handling
//             deleteButton.dataset.subjectId = subject.id; // Store subject ID

//             // Append elements
//             subjectElem.appendChild(title);
//             subjectElem.appendChild(alertsList);
//             subjectElem.appendChild(editButton); // Append Edit button
//             subjectElem.appendChild(deleteButton); // Append Delete button
//             container.appendChild(subjectElem);
//         });
//     })
//     .catch(error => console.error('Error:', error));
// }


function fetchAndDisplaySubjects() {
    fetch('fetch_subjects.php')
        .then(response => response.json())
        .then(subjects => {
            const container = document.getElementById('subjectsContainer');
            container.innerHTML = ''; // Clear current contents

            subjects.forEach(subject => {
                const subjectElem = document.createElement('div');
                subjectElem.classList.add('subject');
                subjectElem.id = `subject-${subject.id}`;

                const title = document.createElement('h3');
                title.textContent = subject.name;
                subjectElem.appendChild(title);

                const now = new Date();

                subject.alerts.forEach(alert => {
                    const alertDate = new Date(alert);
                    const listItem = document.createElement('li');
                    const dateOptions = {
                        weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric',
                        hour: '2-digit', minute: '2-digit', second: '2-digit'
                    };
                    // listItem.textContent = alertDate.toLocaleString();
                    listItem.textContent = new Date(alertDate).toLocaleString('en-US', dateOptions);

                    //Determine the status of the alert based on its date
                    const timeDiff = alertDate - now;
                    if (timeDiff < 0) {
                        listItem.classList.add('alert-completed'); // Past alerts
                    } else if (timeDiff < 60 * 60 * 1000) { // Within the next hour
                        listItem.classList.add('alert-coming-soon');
                    } else {
                        listItem.classList.add('alert-future'); // Future alerts
                    }

                    subjectElem.appendChild(listItem);
                });

                // Append Edit and Delete buttons
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.classList.add('edit-button');
                editButton.dataset.subjectId = subject.id;

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.classList.add('delete-button');
                deleteButton.dataset.subjectId = subject.id;

                subjectElem.appendChild(editButton);
                subjectElem.appendChild(deleteButton);

                container.appendChild(subjectElem);
            });
        })
        .catch(error => {
            console.error('Error fetching and displaying subjects:', error);
        });
}





// Delegated event handling for edit and delete actions
document.getElementById('subjectsContainer').addEventListener('click', function (event) {
    const target = event.target;
    const subjectId = target.dataset.subjectId;

    if (target.classList.contains('edit-button')) {
        editSubject(subjectId);
    } else if (target.classList.contains('delete-button')) {
        deleteSubject(subjectId);
    }
});

// Edit a subject
function editSubject(subjectId) {
    const newName = prompt("Enter the new name for the subject:");
    if (newName) {
        fetch('edit_subject.php', {
            method: 'POST',
            body: JSON.stringify({ id: subjectId, name: newName }),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Subject updated successfully.');
                    fetchAndDisplaySubjects(); // Refresh the subjects list
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

// Delete a subject
function deleteSubject(subjectId) {
    if (confirm("Are you sure you want to delete this subject?")) {
        fetch('delete_subject.php', {
            method: 'POST',
            body: JSON.stringify({ id: subjectId }),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Subject deleted successfully.');
                    fetchAndDisplaySubjects(); // Refresh the subjects list
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

// Initial fetch and display of subjects
fetchAndDisplaySubjects();



//************************* Themes *************************
//************************* Themes *************************
// Toggle Theme
function toggleTheme(theme) {
    if (theme === 'system') {
        // Use system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    } else {
        // Set user-selected theme
        document.documentElement.setAttribute('data-theme', theme);
    }
}


// Detect System Theme Changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    const newColorScheme = event.matches ? "dark" : "light";
    toggleTheme(newColorScheme);
});


// Save User Preference
// save the user's theme preference in local storage and apply it when the app loads.
function saveThemePreference(theme) {
    localStorage.setItem('themePreference', theme);
    toggleTheme(theme);
}

// On app load
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('themePreference') || 'system';
    toggleTheme(savedTheme);
});