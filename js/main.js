'use strict';

// Initiate Player Array
const classMates = ['', 'Robert N', 'Lars K', 'Joakim R', 'Benjamin R', 'Marie E', 'Maria GN',
		               'Axel B', 'Amin E-R', 'André H', 'Carl Å', 'Christian B', 'Katarina C',
		               'Erica G', 'Jeremy D', 'Kristjan F', 'Mathias K', 'Signe B', 'Staffan M',
		               'Victor O', 'Max S', 'Johannes T', 'Vincent K', 'Harry E (Revolutionist)'];
classMates.sort(); // ...and sort it

// Get some elements and assign variables
const playCount = document.querySelector("#playCount");
const selectContainer = document.querySelector("#selectContainer");

// Remove children if they exist
while (selectContainer.hasChildNodes()) {
  selectContainer.removeChild(selectContainer.lastChild);
};

// Function for dynamically adding selectboxes
const selectBoxes = function() {

    // Dynamically add select options
    if (!playCount.value) {
        selectContainer.style.display = 'none'; // Hide Select-container if empty.
    } else {
        selectContainer.style.display = 'block';
        for (let i = playCount.value; i > 0; i--) {
            const select = document.createElement('select');
            select.name = classMates[this];
            selectContainer.appendChild(select);
        }
    }
};

// Start eventhandler for selectBoxes function and actually use it
playCount.addEventListener('change', selectBoxes());
