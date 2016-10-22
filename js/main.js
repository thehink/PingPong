'use strict';

// Initiate Player Array
const classMates = ['', 'Robert N', 'Lars K', 'Joakim R', 'Benjamin R', 'Marie E', 'Maria GN',
		               'Axel B', 'Amin E-R', 'André H', 'Carl Å', 'Christian B', 'Katarina C',
		               'Erica G', 'Jeremy D', 'Kristjan F', 'Mathias K', 'Signe B', 'Staffan M',
		               'Victor O', 'Max S', 'Johannes T', 'Vincent K', 'Harry E (Revolutionist)'];
classMates.sort(); // ...and sort it

// Get some elements and assign variables
const playCount = document.querySelector("#playerCount");
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

          // First we add the label
          const label = selectContainer.appendChild(document.createElement('label'));
          label.htmlFor = 'players[]';
          label.className = 'label';
          label.innerHTML = 'Player:';

          // Add the right amount of selectboxes
          selectContainer.appendChild(document.createElement('select'));
          const select = document.querySelectorAll('select');
          select.forEach( function (singleSelect) {
            singleSelect.className = 'selectBox';
            singleSelect.name = 'player[]';
          });
        }
    }
};

// Function for adding all the names to the options
const optionBoxes = function() {

  // Place selectBoxes in variable
  const selectBoxes = document.querySelectorAll('.selectBox');

  // Place all the options in each selectbox
  selectBoxes.forEach(function(box){
    for (let i = 0; i < classMates.length; i++) {
      const optionBox = box.appendChild(document.createElement('option'));
      optionBox.value = i;
      optionBox.innerHTML = classMates[i];
    }
  });
};

// Start eventhandler for selectBoxes function and actually use it
playCount.addEventListener('change', selectBoxes());
optionBoxes();
