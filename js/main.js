'use strict';

const SortedPlayers = players.sort(function(a, b){
	var nameA = a.firstname.toUpperCase(); // ignore upper and lowercase
  var nameB = b.firstname.toUpperCase(); // ignore upper and lowercase
	if (nameA < nameB) {
    return -1;
  }
  if (nameA > nameB) {
    return 1;
  }
  // names must be equal
  return 0;
});

selectedPlayers = selectedPlayers.map(function(id){
  return parseInt(id);
});

let playerCount = selectedPlayers.length || 2;
let oldVals = {};

// Get PlayerCount form
const playCount = document.querySelector("#playerCountForm");
playCount.remove();

const wrapper = document.querySelector('#playersFormWrapper');
//playCount.querySelector('input').value = playerCount;


wrapper.appendChild(buildPlayerOptions());
document.querySelector('.unselected').focus();

function onPlayerOptionChanged(event){
  let oldVal = oldVals[event.target.id] || -1;
  let newVal = parseInt(event.target.value);
  let oldIndex = selectedPlayers.indexOf(oldVal);
  if(oldIndex > -1){
    selectedPlayers.splice(oldIndex, 1);
  }

  if(newVal > -1 && oldIndex > -1){
    selectedPlayers.splice(oldIndex, 0, newVal);
  }
  else if(newVal > -1){
    selectedPlayers.push(newVal);
  }

//delete previous nodes
	wrapper.innerHTML = '';


  let node = buildPlayerOptions();
	//insert after playerCount form
  wrapper.appendChild(node);
  document.querySelector('.unselected').focus();
}

function buildPlayerOptions(){
  oldVals = {};
	//start building form
	const form = document.createElement('form');
	form.id = 'playersForm';
	form.method = 'POST';
	form.action = 'index.php';

  let l = selectedPlayers.length < 2 ? 2 : selectedPlayers.length+1;

	for(let i = 0; i < l; ++i){
    let player = players.find(function(player){
      return player.id === selectedPlayers[i];
    });

		let select = document.createElement('select');
		select.className = 'selectBox';
    select.name = 'selectedPlayers[]';
		select.id = 'player'+(i+1);



    if(player){
      oldVals[select.id] = player.id;
      let option = document.createElement('option');
			option.value = player.id;
	    option.innerText = player.firstname;
			select.appendChild(option);
    }else{
      select.className = 'selectBox unselected';
    }

    let option = document.createElement('option');
		option.value = -1;
    option.innerText = 'Select player...';
		select.appendChild(option);

		for(let j = 0; j < players.length; ++j){
      if(selectedPlayers.indexOf(players[j].id) > -1){
        continue;
      }
			let option = document.createElement('option');
			option.value = players[j].id;
	    option.innerText = players[j].firstname;
			select.appendChild(option);
		}

		select.addEventListener('change', onPlayerOptionChanged);

		form.appendChild(select);
	}

	let button = document.createElement('button');
	button.type = 'submit';
	button.innerText = 'New Round';
	form.appendChild(button);

	form.addEventListener('submit', function(event){
		//check to make sure no select is empty
		if(selectedPlayers.length < 2){
      event.preventDefault();
      alert('You need a minimum of 2 players!');
    }
	});

	return form;
}
