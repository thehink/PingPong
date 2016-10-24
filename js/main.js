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

let selectedOptions = {};
let playerCount = selectedPlayers.length || 2;


// Get PlayerCount form
const playCount = document.querySelector("#playerCountForm");
playCount.querySelector('input').value = playerCount;

if(selectedPlayers.length > 0){
	selectedPlayers.forEach(function(id, i){
		selectedOptions['player'+(i+1)] = players.find(function(player){return parseInt(player.id)===parseInt(id)});
	});
	playCount.parentNode.insertBefore(buildPlayerOptions(playerCount), playCount.nextSibling);
	rebuildOptions();
}

function onPlayerCountSubmit(event){
	//prevent submit of playercount
	event.preventDefault();

	//get value of player count input
	playerCount = playCount.querySelector('input').value;

	//reset selected options
	//selectedOptions = {};

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

	if(!error){
		rebuildOptions();
	}
}

function buildPlayerOptions(playerCount){
	//start building form
	const form = document.createElement('form');
	form.id = 'playersForm';
	form.method = 'POST';
	form.action = 'index.php';

	for(let i = 0; i < playerCount; ++i){

		let select = document.createElement('select');
		select.className = 'selectBox';
    select.name = 'selectedPlayers[]';
		select.id = 'player'+(i+1);

		let option = document.createElement('option');
		option.value = -1;
		select.appendChild(option);

		for(let j = 0; j < players.length; ++j){
			let option = document.createElement('option');
			option.value = players[j].id;
	    option.innerText = players[j].firstname;
			select.appendChild(option);
		}

		select.addEventListener('change', onOptionChange);

		form.appendChild(select);

	}

	let button = document.createElement('button');
	button.type = 'submit';
	button.innerText = 'New Round';
	form.appendChild(button);

	form.addEventListener('submit', function(event){
		//check to make sure no select is empty
		for(let i = 0; i < playerCount; ++i){
			if(!selectedOptions['player' + (i+1)]){
				alert('You need to select all players!');
				return event.preventDefault();
			}
		}
	});

	return form;
}

function rebuildOptions(){
	//store all selected player ids here
		let usedPlayers = [];

	//push all selected players to the usedPlayers array
		for(let key in selectedOptions){
			let numPlayer = parseInt(key.replace('player',''));
			if(numPlayer <= playerCount){
				usedPlayers.push(parseInt(selectedOptions[key].id));
			}
		}

	//loop through all select boxes
		for(let i = 0; i < playerCount; ++i){
			const select = document.querySelector("#player" + (i+1));
			const selectedOption = selectedOptions[select.id];

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
			if(selectedOption){
				let option = document.createElement('option');
				option.value = selectedOption.id;
				option.innerText = selectedOption.firstname;
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

//this is where the magic happens
function onOptionChange(event){
	const playerId = parseInt(event.target.value);

//store selected player so we can access it later
	selectedOptions[event.target.id] = SortedPlayers.find(function(player){
		return player.id === playerId;
	});

	rebuildOptions();
}

playCount.addEventListener('submit', onPlayerCountSubmit);
