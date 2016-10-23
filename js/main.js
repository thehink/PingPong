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

let selectedPlayers = {};
let playerCount = 2;


// Get PlayerCount form
const playCount = document.querySelector("#playerCountForm");

function onPlayerCountSubmit(event){
	//prevent submit of playercount
	event.preventDefault();

	//get value of player count input
	playerCount = playCount.querySelector('input').value;

	//reset selected players
	selectedPlayers = [];

//define error variable
	let error;

//check for errors
	if(playerCount > SortedPlayers.length){
		error = 'Max ' + SortedPlayers.length + ' players!';
	}

	if(playerCount < 2){
		error = 'Min 2 players!';
	}

//delete previous nodes
	const oldNodes = document.querySelectorAll("#playersForm, .nameFieldErrorMessage");
	if(oldNodes){
		oldNodes.forEach(function(node){
			node.remove();
		});
	}

//if errors build a span and display errors or build player select form
	let node;
	if(error){
		node = document.createElement('span');
		node.className = 'nameFieldErrorMessage';
		node.innerText = error;
	}else{
		node = buildPlayerOptions(playerCount);
	}

	//insert after playerCount form
	playCount.parentNode.insertBefore(node, playCount.nextSibling);
}

function buildPlayerOptions(playerCount){
	//start building form
	const form = document.createElement('form');
	form.id = 'playersForm';
	form.method = 'POST';
	form.action = 'index.php';

	const label = document.createElement('label');
	label.className = 'label';
	label.innerText = 'Enter player names';

	//form.appendChild(label);

	for(let i = 0; i < playerCount; ++i){
		let selectLabel = document.createElement('label');
		selectLabel.innerText = 'Player ' + (i+1);

		let select = document.createElement('select');
		select.className = 'selectBox';
    select.name = 'selectedPlayers[]';
		select.id = 'player'+(i+1);

		let option = document.createElement('option');
		option.value = -1;
		option.innerText = 'Select player...';
		select.appendChild(option);

		for(let j = 0; j < players.length; ++j){
			let option = document.createElement('option');
			option.value = players[j].id;
	    option.innerText = players[j].firstname;
			select.appendChild(option);
		}

		select.addEventListener('change', onOptionChange);

		form.appendChild(selectLabel);
		form.appendChild(select);

	}

	let button = document.createElement('button');
	button.type = 'submit';
	button.innerText = 'New Round';
	form.appendChild(button);

	form.addEventListener('submit', function(event){
		//check to make sure no select is empty
		for(let i = 0; i < playerCount; ++i){
			if(!selectedPlayers['player' + (i+1)]){
				alert('You need to select all players!');
				return event.preventDefault();
			}
		}
	});

	return form;
}

//this is where the magic happens
function onOptionChange(event){
	const playerId = parseInt(event.target.value);

//store selected player so we can access it later
	selectedPlayers[event.target.id] = SortedPlayers.find(function(player){
		return player.id === playerId;
	});

//stor all selected player ids here
	let usedPlayers = [];

//push all selected players to the usedPlayers array
	for(let i = 0; i < playerCount; ++i){
		const select = document.querySelector("#player" + (i+1));
		usedPlayers.push(parseInt(select.value));
	}

//loop through all select boxes
	for(let i = 0; i < playerCount; ++i){
		const select = document.querySelector("#player" + (i+1));
		const selectedPlayer = selectedPlayers[select.id];

//filter out all used players
		let filteredPlayers = SortedPlayers.filter(function(player){
			return usedPlayers.indexOf(parseInt(player.id)) === -1;
		});

//remove all options
		while (select.firstChild) {
		  select.removeChild(select.firstChild);
		}

//if we have selected a player for this dropdown previously append it first.
//else append a default Select player... option
		if(selectedPlayer){
			let option = document.createElement('option');
			option.value = selectedPlayer.id;
			option.innerText = selectedPlayer.firstname;
			select.appendChild(option);
		}else{
			let option = document.createElement('option');
			option.value = -1;
			option.innerText = 'Select player...';
			select.appendChild(option);
		}

//then add the rest of the filtered players to the dropdown
		filteredPlayers.forEach(function(player){
			let option = document.createElement('option');
			option.value = player.id;
	    option.innerText = player.firstname;
			select.appendChild(option);
		})
	}
}

playCount.addEventListener('submit', onPlayerCountSubmit);
